<?php

namespace Eduka\Abstracts;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EdukaMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $course;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;

        // Not the best approach since we are serializing the course instance.
        // Should serialize only the course id.
        $this->course = course();
    }

    public function build()
    {
        /**
         * Register the respective course service provider. Since this is a job
         * we need to statically record that information since it runs as a
         * console so no course service provider context will be automatically
         * initialized by eduka nereus.
         *
         * If the mailable is from the backend, then there is no need to
         * register a service provider, since it's already automatically
         * registered.
         */
        app()->register($this->course->provider_namespace);
    }
}
