<?php

namespace App\Jobs;

use App\Exports\MemberExport;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;
use File;

class ExportMemberJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $search;
    public $orderField;
    public $tableName;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tableName, $search, $orderField)
    {
        $this->tableName = $tableName;
        $this->search = $search;
        $this->orderField = $orderField;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $path = Excel::store(new MemberExport($this->tableName,$this->search, $this->orderField), 'ListMember.xlsx',);
        (new MemberExport($this->tableName, $this->search, $this->orderField))->store('xlsx/ListMember.xlsx', 'public');
        // echo('end');
        // sleep(2);
        // echo("done");
        // E:\office_app\storage\app\public\avatars\xlsx\ListMember.zip

        // $zip = new ZipArchive;
        // $res = $zip->open(Storage::disk("avatars")->path('xlsx/ListMember.zip'), ZipArchive::CREATE);
        // if ($res === TRUE) {
        //     $zip->addFile(Storage::disk("avatars")->path('xlsx/ListMember.xlsx'),'ListMember.xlsx');
        //     $zip->setEncryptionName('ListMember.xlsx', ZipArchive::EM_AES_256, 'password');
        //     $zip->close();
        //     echo 'ok';
        // } else {
        //     echo 'failed';
        // }
        $zip = new ZipArchive;
        $res = $zip->open(storage_path('app/public/xlsx/test.zip'), ZipArchive::CREATE);
        if ($res === TRUE) {
            $zip->addFile(storage_path('app/public/xlsx/ListMember.xlsx'),'ListMember.xlsx');
            $zip->setEncryptionName('ListMember.xlsx', ZipArchive::EM_AES_256, 'passw0rd');
            $zip->close();
            echo 'ok';
        } else {
            echo 'failed';
        }
    }
}
