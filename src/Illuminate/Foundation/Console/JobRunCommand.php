<?php

namespace Illuminate\Foundation\Console;

use Illuminate\Console\Command;
use Illuminate\Contracts\Queue\ShouldQueue;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'run:job')]
class JobRunCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'run:job {class}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs an existing job class';

    /**
     * Execute the console command.
     *
     * @return int
     *
     * @throws \Exception
     */
    public function handle()
    {
        $class = $this->argument('class');

        if (! class_exists($class)) {
            $this->error("Class [$class] does not exist.");
            return self::FAILURE;
        }

        if (! is_subclass_of($class, ShouldQueue::class)) {
            $this->error("Class [$class] is not a job.");
            return self::FAILURE;
        }

        $this->info("Dispatching $class...");

        app($class)?->dispatch();

        return self::SUCCESS;
    }
}
