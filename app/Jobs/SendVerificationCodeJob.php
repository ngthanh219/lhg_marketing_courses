<?php

namespace App\Jobs;

use App\Mail\SendVerificationCodeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendVerificationCodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;
    public $verficationCode;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $verficationCode)
    {
        $this->email = $email;
        $this->verficationCode = $verficationCode;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new SendVerificationCodeMail($this->verficationCode));
    }
}
