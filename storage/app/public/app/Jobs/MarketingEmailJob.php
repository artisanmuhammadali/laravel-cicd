<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\UserEmail;


class MarketingEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;
    protected $users;
    protected $subject;
    protected $body;
    protected $email_id;
    public function __construct($users,$subject,$body,$email_id)
    {
        $this->users = $users;
        $this->body = $body;
        $this->subject = $subject;
        $this->email_id = $email_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach($this->users as $user)
        {
            UserEmail::create(['email_id' => $this->email_id, 'user_id' => $user->id]);
          sendMail([
            'view' => 'admin.marketing.preview',
            'to' => $user->email,
            'subject' => $this->subject,
            'data' => [
                'content'=>$this->body,
                'marketing'=> $user->store &&  $user->store->newsletter == 'on' ? 'on' : null,
                'email'=> base64_encode($user->email),
            ]
           ]);
        }
    }
}
