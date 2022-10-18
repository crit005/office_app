<?php

namespace App\Http\Livewire\Components;

use App\Jobs\ExportMemberJob;
use App\Models\Notifications;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use ZipArchive;

class ExportButton extends Component
{
    public $isDownloading = false;
    public $downloadLink = 'app/public/xlsx/';
    public $pageName;

    public $search = null;
    public $orderField = ['field' => 'last_active', 'order' => 'desc'];

    public $exporting = null;
    public $exportType = '';
    public $fromDate = '';
    public $toDate = '';
    public $firstData = [];
    public $exportData = [];

    public $totalRecord = 0;

    public $connection = null;

    protected $listeners = [
        'ExportButton_SetOrderField' => 'setOrderField',
        'ExportButton_SetSearch' => 'setSearch',
        'ExportButton_SetExportType' => 'setExportType',
        'ExportButton_SetFromDate' => 'setFromDate',
        'ExportButton_SetToDate' => 'setToDate',
        'ExportButton_SetTotalRecord' => 'setTotalRecord',
    ];

    // public function mount($pageName)
    public function mount($firstData)
    {
        if (!Session::get('selectedSystem')) {
            return redirect(route('dashboard'));
        }
        $this->connection = Session::get('selectedSystem');
        // $this->pageName = $pageName;
        $this->firstData = $firstData;
        $this->pageName = $this->firstData['pageName'];
        $this->exportType = $this->firstData['exportType'];
        $this->orderField = $this->firstData['orderField'];
        if (array_key_exists('totalRecord', $firstData)) {
            $this->totalRecord = $firstData['totalRecord'];
        }
        if (array_key_exists('fromDate', $firstData)) {
            $this->fromDate = $firstData['fromDate'];
        }
        if (array_key_exists('toDate', $firstData)) {
            $this->toDate = $firstData['toDate'];
        }
        $this->checkExportJob();
    }

    public function setOrderField($orderField)
    {
        $this->orderField = $orderField;
    }
    public function setSearch($search)
    {
        $this->search = $search;
    }
    public function setExportType($exportType)
    {
        $this->exportType = $exportType;
    }
    public function setFromDate($fromDate)
    {
        $this->fromDate = $fromDate;
    }
    public function setToDate($toDate)
    {
        $this->toDate = $toDate;
    }
    public function setTotalRecord($totalRecord)
    {
        $this->totalRecord = $totalRecord;
    }

    public function checkExportJob()
    {
        $notification = Notifications::where('user_id', '=', Auth()->user()->id)
            ->where('page', '=', $this->pageName)
            ->whereIn('status', ['READY_ALERT', 'SUCCESS_ALERT', 'PROCESSING'])
            ->first();
        if ($notification) {
            $this->exporting = [
                "id" => $notification->id,
                "status" => $notification->status,
                "downloadLink" => $notification->download_link
            ];
        } else {
            $this->exporting = null;
        }
        unset($notification);
    }


    public function doDownload()
    {
        $this->emit('ListCustomer_DoDownload', $this->exporting);
        $this->exporting = null;
    }

    public function doDeleteExport()
    {
        $this->emit('ListCustomer_DoDeleteExport', $this->exporting);
        $this->exporting = null;
    }


    // complimize function

    public function doExport($protectData)
    {
        $this->isDownloading = true;
        // return Excel::download(new MemberExport($this->search, $this->orderField), 'ListMember.xlsx');
        $download_name = $protectData['fileName'] . strtotime(now());

        // កំណត់ចំនួន Files ដែលត្រូវ export
        $numberOfFiles = (int)($this->totalRecord / 10000);
        if (($this->totalRecord % 10000) > 0) {
            $numberOfFiles += 1;
        }

        // បង្កើតអារេហ្វាល
        $fileNames = [];
        for($i=0; $i<$numberOfFiles; $i++){
            array_push($fileNames,[
                'temFile'=>($download_name."_".$i+1),
                'fileName'=>($protectData['fileName'].'_'. $i+1)]
            );
        }

        // Create notification type PROCESSING
        $notificationData = null;
        $notificationData['user_id'] = Auth::user()->id;
        $notificationData['title'] = 'Customer Exporting';
        $notificationData['message'] = 'Exporting ' . $protectData['fileName'] . ' is in progress please wait';
        $notificationData['file_name'] = $protectData['fileName'];
        $notificationData['page'] = $this->pageName;
        $notificationData['type'] = 'DOWNLOAD';

        $notificationData['download_link'] = $this->downloadLink . $download_name . '.zip';
        // $notificationData['batch_id'] = $batch->id;
        $notificationData['status'] = 'PROCESSING';
        $notification = Notifications::create($notificationData);

        //
        $this->exportData = [
            "exportType" => $this->exportType,
            "tableName" => $this->connection->connection_name,
            "orderField" => $this->orderField,
            "fileName" => $protectData['fileName'],
            "download_name" => $download_name,
            "password" => $protectData['password'],
            "userId" => Auth::user()->id,
            // "batch_id" => $batch->id,
            "notification_id" => $notification->id
        ];

        // បង្កើតបាច់ហ្វាល
        // $batch = Bus::batch([])->then(function (Batch $abatch) use($fileNames,$download_name) {
        $batch = Bus::batch([])->then(function (Batch $abatch) use($fileNames,$download_name){

            $compressData = [
                'download_name' => $download_name,
                'fileNames' => $fileNames,
                'password' => $this->exportData['password']
            ];
            $this->compressExcellFiles($compressData);

            $notification = Notifications::find($this->exportData['notification_id']);
            if ($notification->status != 'DONE') {
                // $notification->message = $this->data['fileName'] . " is ready to download.";
                $notification->message = $this->exportData['fileName'] . " is ready to download.";
                $notification->status = 'SUCCESS_ALERT';
                $notification->save();
            }

            unset($notification);
            unset($compressData);
            // dd($this->exportData['notification_id']);
            // dd($fileNames);
        })->dispatch();

        // notification

        $index = 0;
        foreach ($fileNames as $fileName) {
            $data = [
                "exportType" => $this->exportType,
                "tableName" => $this->connection->connection_name,
                "orderField" => $this->orderField,
                // "fileName" => $protectData['fileName'],
                "fileName" => $fileName['temFile'],
                //! problem with download name only 1 name
                "download_name" => $download_name,
                "password" => $protectData['password'],
                "userId" => Auth::user()->id,
                "search" => $this->search,
                "batch_id" => $batch->id,
                "notification_id" => $notification->id,
                "fromDate" => $this->fromDate,
                "toDate" => $this->toDate,
                "skip" => $index * 10000,
                "take" => 10000
                // "fileNames" => $fileNames
            ];

            // dd($data);
            $batch->add(new ExportMemberJob($data));
            $index++;
        }
        // unset($index);

        //! old export all in one file
        // // Exporting data
        // $data = [
        //     "exportType" => $this->exportType,
        //     "tableName" => $this->connection->connection_name,
        //     "orderField" => $this->orderField,
        //     "fileName" => $protectData['fileName'],
        //     "download_name" => $download_name,
        //     "password" => $protectData['password'],
        //     "userId" => Auth::user()->id,
        //     "search" => $this->search,
        //     "batch_id" => $batch->id,
        //     "notification_id" => $notification->id,
        //     "fromDate" => $this->fromDate,
        //     "toDate" => $this->toDate,
        //     "skip" => 0,
        //     "take" => 10000,
        //     "fileNames" => $fileNames
        // ];

        // // dd($data);
        // $batch->add(new ExportMemberJob($data));

        // unset($notification);
        //! End old export all in one file
    }

    /**
     * compressExcellFiles
     * $compressData[
     *  'download_name'=>string
     *  'fileNames'=>['excel1', 'excel2',...]
     *  'password'=>''
     * ]
     */
    public function compressExcellFiles($compressData)
    {

        //! make zip by loop thrue to excelfiles and add to one zip file
        $zip = new ZipArchive;
        $res = $zip->open(storage_path('app/public/xlsx/' . $compressData['download_name'] . '_Enc.zip'), ZipArchive::CREATE);
        if ($res === TRUE) {

            foreach ($compressData['fileNames'] as $excelFile) {
                $zip->addFile(storage_path('app/public/xlsx/' . $excelFile['temFile'].'.xlsx'), $excelFile['fileName'].'.xlsx');
                // unlink(storage_path('app/public/xlsx/' . $excelFile['temFile'].'.xlsx'));
                // $zip->setEncryptionName($excelFile['fileName'].'.xlsx', ZipArchive::EM_AES_256, $compressData['password']);
            }
            // $zip->setPassword($compressData['password']);
            $zip->close();


        } else {
            echo 'failed';
        }

        // delete excel files
        foreach ($compressData['fileNames'] as $excelFile) {
            unlink(storage_path('app/public/xlsx/' . $excelFile['temFile'].'.xlsx'));
        }

        $zipFinall = new ZipArchive;
        $resFinall = $zipFinall->open(storage_path('app/public/xlsx/' . $compressData['download_name'] . '.zip'), ZipArchive::CREATE);
        if ($resFinall === TRUE) {
            $zipFinall->addFile(storage_path('app/public/xlsx/' . $compressData['download_name'] . '_Enc.zip'), $compressData['download_name'] . '_Enc.zip');
            // unlink(storage_path('app/public/xlsx/' . $compressData['download_name'] . '_Enc.zip'));
            $zipFinall->setEncryptionName($compressData['download_name'] . '_Enc.zip', ZipArchive::EM_AES_256, $compressData['password']);
            $zipFinall->close();

        } else {
            echo 'failed to create final zip';
        }
        unlink(storage_path('app/public/xlsx/' . $compressData['download_name'] . '_Enc.zip'));
    }


    public function doDownload_F()
    {
        // return storage::disk('avatars')->download("oV9hMeNdtJL6ZpDaaH3CdHsRM2ofCKKR6ijh0aFx.png"); // cannot delete affter download
        $notification = Notifications::find($this->exporting['id']);
        $notification->status = "DONE";
        $notification->description .= "_(DOWNLOADED)_";
        $notification->save();
        $file = $this->exporting['downloadLink'];
        // $this->exporting = null;
        unset($notification);
        return response()->download(storage_path($file))->deleteFileAfterSend(true);
    }

    public function doDeleteExport_F()
    {
        //! cancel batch and delete job later;
        // $notification = Notifications::find($this->exporting['id']);
        $notification = Notifications::find($this->exporting['id']);
        $notification->status = "DONE";
        $notification->description .= "_(CANCELED)_";
        $notification->save();
        $file = $this->exporting['downloadLink'];
        unlink(storage_path($file));
        // $this->exporting = null;
        unset($notification);
    }


    // end reall function

    public function render()
    {
        return view('livewire.components.export-button');
    }
}
