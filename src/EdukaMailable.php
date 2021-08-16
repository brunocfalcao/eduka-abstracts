<?php

namespace Eduka\Abstracts;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EdukaMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $targetView;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->from(
            $this->data['course']->from_email,
            $this->data['course']->from_name
        )
                    ->with('notifiable', $this->data['notifiable'])
                    ->with('data', $this->data['data'])
                    ->with('course', $this->data['course'])
                    ->view($this->targetView);
    }
}
