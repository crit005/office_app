<?php

namespace App\Jobs;

use App\Exports\MemberExport;
use App\Models\Notifications;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ZipArchive;

class ExportMemberJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data;
    public $timeout = 0;
    /**
     * Create a new job instance.
     *
     * @return void
     * data is an aray conten tableName search orderField fileName password and user(Auth::user())
     */
    public function __construct($data)
    {
        $this->data = $data;
        ini_set('memory_limit', -1);
        ini_set('max_execution_time', 1800);
        ini_set('max_input_time', 1200);
        set_time_limit ( 0 );
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        ini_set('memory_limit', -1);
        ini_set('max_execution_time', 1800);
        ini_set('max_input_time', 1200);
        set_time_limit ( 0 );
        (new MemberExport($this->data))->store('xlsx/' . $this->data['download_name'] . '.xlsx', 'public');

        $zip = new ZipArchive;
        $res = $zip->open(storage_path('app/public/xlsx/' . $this->data['download_name'] . '.zip'), ZipArchive::CREATE);
        if ($res === TRUE) {
            $zip->addFile(storage_path('app/public/xlsx/' . $this->data['download_name'] . '.xlsx'), $this->data['download_name'] . '.xlsx');
            $zip->setEncryptionName($this->data['download_name'] . '.xlsx', ZipArchive::EM_AES_256, $this->data['password']);
            $zip->close();
            unlink(storage_path('app/public/xlsx/' . $this->data['download_name'] . '.xlsx'));
        } else {
            echo 'failed';
        }
        $notification = Notifications::find($this->data['notification_id']);
        if ($notification->status != 'DONE') {
            $notification->message = $this->data['fileName'] . " is ready to download.";
            $notification->status = 'SUCCESS_ALERT';
            $notification->save();
        }
        unset($notification);
        //
    }
}
