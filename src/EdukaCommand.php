<?php

namespace Eduka\Abstracts;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Process\Process;

abstract class EdukaCommand extends Command
{
    protected function paragraph($text, $endlf = true, $startlf = true)
    {
        if ($startlf) {
            $this->info('');
        }
        $this->info($text);
        if ($endlf) {
            $this->info('');
        }
    }

    /**
     * Run the given command as a process.
     *
     * @param  string  $command
     * @param  string  $path
     * @return void
     */
    protected function executeCommand($command, $path)
    {
        $process = (Process::fromShellCommandline($command, $path))->setTimeout(null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            $process->setTty(true);
        }

        $process->run(function ($type, $line) {
            $this->output->write($line);
        });
    }

    /**
     * Console prompt, but enpowered with rules.
     *
     * @param string $question
     * @param string $rules
     *
     * @return mixed
     */
    protected function askWithRules(string $question, string $rules)
    {
        $exit = false;
        $answer = null;

        while (! $exit) {
            $answer = $this->ask($question);
            $validator = Validator::make(
                [$question => $answer],
                [$question => $rules]
            );

            if ($validator->fails()) {
                $this->error($validator->errors()->first());
                $exit = false;
            } else {
                $exit = true;
            }
        }

        return $answer;
    }
}
