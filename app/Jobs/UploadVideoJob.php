<?php

namespace App\Jobs;

use App\Helpers\GeneralHelper;
use App\Libraries\Constant;
use App\Models\Video;
use App\Services\AWSS3Service;
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

    public $sourceUrl;
    public $videoId;
    public $oldSourceUrl;

    /**
     * Create a new job instance.
     */
    public function __construct($sourceUrl, $videoId, $oldSourceUrl = null)
    {
        $this->sourceUrl = $sourceUrl;
        $this->videoId = $videoId;
        $this->oldSourceUrl = $oldSourceUrl;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $isSuccess = false;
        $awsS3Service = new AWSS3Service();
        GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Video is uploading', ['source' => $this->sourceUrl], true);

        try {
            $video = Video::find($this->videoId);
            $file = Storage::disk(Constant::STORAGE_DISK_LOCAL)->get($this->sourceUrl);
            Storage::disk('s3')->put($this->sourceUrl, $file);
            Storage::disk(Constant::STORAGE_DISK_LOCAL)->delete($this->sourceUrl);

            if ($this->oldSourceUrl) {
                $video->update([
                    'source' => $this->sourceUrl
                ]);
            }

            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Video is uploaded', ['source' => $this->sourceUrl], [], true);

            $isSuccess = true;
        } catch (\Exception $ex) {
            $isSuccess = false;
            
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            $awsS3Service->removeFile($this->sourceUrl);
            if (Storage::disk(Constant::STORAGE_DISK_LOCAL)->exists($this->sourceUrl)) {
                Storage::disk(Constant::STORAGE_DISK_LOCAL)->delete($this->sourceUrl);
            }

            if (!$this->oldSourceUrl) {
                $video->update([
                    'source' => null
                ]);
            }

            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Video is deleted', ['source' => $this->sourceUrl], [], true);
        }

        if ($this->oldSourceUrl && $isSuccess) {
            try {
                GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Old video is deleting', ['source' => $this->oldSourceUrl], true);
        
                $awsS3Service->removeFile($this->oldSourceUrl);
        
                GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Old video is deleted', ['source' => $this->oldSourceUrl], true);
            } catch (\Exception $ex) {
                GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

                $awsS3Service->removeFile($this->oldSourceUrl);

                GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Old video is deleted', ['source' => $this->sourceUrl], [], true);
            }
        }
    }
}
