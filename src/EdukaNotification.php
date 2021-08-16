<?php

namespace Eduka\Abstracts;

use Eduka\Pathfinder\Pathfinder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class EdukaNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $course;
    protected $data;
    protected $mailableClass;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $configPath, array $data = [])
    {
        // Not the best approach since we are serializing the course instance.
        // Should serialize only the course id.
        $this->course = course();

        /**
         * For persistency reasons we need to persist the source url.
         * Since the notification runs in an assyncronous queue, it will not
         * know what was the source course url that it came from.
         */
        $this->url = url();

        $this->data = $data;
        $this->mailableClass = config_course($configPath);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        Pathfinder::contextualize($this->course);

        // Send a "thank you for subscribing" notification.
        return (new $this->mailableClass([
            'notifiable' => $notifiable,
            'data' => $this->data,
            'course' => $this->course, ]))
                        ->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
