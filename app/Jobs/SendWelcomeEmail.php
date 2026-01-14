<?php

namespace App\Jobs;

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;

class SendWelcomeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    protected $userId;

    // Constructor accepteert de user_id in plaats van het hele object
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    // De handle functie die de job uitvoert
    public function handle()
    {
        $user = User::find($this->userId);

        if ($user) {
            Mail::to($user->email)->send(new WelcomeMail());
        }
    }
}
