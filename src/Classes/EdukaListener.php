<?php

namespace Eduka\Abstracts\Classes;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

abstract class EdukaListener implements ShouldQueue
{
    use InteractsWithQueue;

    public $tries = 3;
}
