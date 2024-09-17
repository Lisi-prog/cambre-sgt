<?php

namespace App\Jobs;

use App\Mail\ScheduledMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class SendScheduledMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $users;
    
    public function __construct($users)
    {
        $this->users = $users;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /* foreach ($this->users as $user) {
            $data = [
                'name' => $user->name,
                'message' => $user->custom_message
            ];
            Mail::to($user->email)->send(new ScheduledMail($data));
        } */
       $us = 18;
        $data = [
            'name' => User::find(2)->name,
            'message' => 'prueba',
            'info' =>  DB::select('CALL ObtenerTotalHorasServicio(?, 7)',[$us])
        ];

        Mail::to('lisandrosilvero@gmail.com')->send(new ScheduledMail($data));
    }
}
