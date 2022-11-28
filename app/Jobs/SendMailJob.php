<?php

namespace App\Jobs;

use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $details;
    public string $email;
    protected User $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $details, string $email, User $user)
    {
        $this->details = $details;
        $this->email = $email;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       Mail::to($this->email)->send(new SendMail($this->details));
    }

    public function tags(){
        return ['user:'.$this->user->id];
    }
}
