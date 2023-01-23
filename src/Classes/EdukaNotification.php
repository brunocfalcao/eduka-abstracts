<?php

namespace Eduka\Abstracts\Classes;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class EdukaNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        //
    }
}