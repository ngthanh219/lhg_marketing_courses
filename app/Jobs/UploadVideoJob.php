<?php

namespace App\Jobs;

use App\Libraries\Constant;
use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class UploadVideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $file;
    public $extension;
    public $videoId;

    /**
     * Create a new job instance.
     */
    public function __construct($file, $extension, $videoId)
    {
        $this->file = $file;
        $this->extension = $extension;
        $this->videoId = $videoId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $fileName = time() . '.' . $this->extension;
        $filePath = Constant::VIDEO_FOLDER . $fileName;
        Storage::disk('s3')->put($filePath, $this->file);

        Video::find($this->videoId)->update([
            'source' => $filePath
        ]);
    }
}
