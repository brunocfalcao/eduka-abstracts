<?php

namespace Eduka\Abstracts;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EdukaMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $provider;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->provider = course()->provider_namespace;
    }
}
