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
    /**
     * Create a new job instance.
     *
     * @return void
     * data is an aray conten tableName search orderField fileName password and user(Auth::user())
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new MemberExport($this->data))->store('xlsx/'.$this->data['fileName'].'.xlsx', 'public');

        $zip = new ZipArchive;
        $res = $zip->open(storage_path('app/public/xlsx/'.$this->data['fileName'].'.zip'), ZipArchive::CREATE);
        if ($res === TRUE) {
            $zip->addFile(storage_path('app/public/xlsx/'.$this->data['fileName'].'.xlsx'), $this->data['fileName'].'.xlsx');
            $zip->setEncryptionName($this->data['fileName'].'.xlsx', ZipArchive::EM_AES_256, $this->data['password']);
            $zip->close();
            unlink(storage_path('app/public/xlsx/'.$this->data['fileName'].'.xlsx'));
        } else {
            echo 'failed';
        }
        $notification = Notifications::find($this->data['notification_id']);

        //
    }
}
