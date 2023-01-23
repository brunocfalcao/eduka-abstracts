<?php

namespace Eduka\Abstracts\Classes;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

abstract class EdukaCommand extends Command
{
    /**
     * Run the given command as a process.
     *
     * @param  string  $command
     * @param  string  $path
     * @return void
     */
    protected function shell($command, $path = null)
    {
        if (! $path) {
            $path = getcwd();
        }

        $process = (Process::fromShellCommandline($command, $path))->setTimeout(null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            $process->setTty(true);
        }

        $process->run(function ($type, $line) {
            $this->output->write($line);
        });
    }
}
