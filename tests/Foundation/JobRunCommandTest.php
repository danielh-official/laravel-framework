<?php

declare(strict_types=1);

namespace Illuminate\Tests\Foundation;

use Illuminate\Foundation\Console\JobRunCommand;
use Illuminate\Support\Facades\Queue;
use Orchestra\Testbench\TestCase;

class JobRunCommandTest extends TestCase
{
    public function testItCanRunSuccessfully(): void
    {
        Queue::fake();

        $class = \FakeJob::class;

        $this->artisan(JobRunCommand::class, compact('class'))
            ->assertSuccessful()
            ->doesntExpectOutputToContain("Class [$class] does not exist.")
            ->doesntExpectOutputToContain("Class [$class] is not a job.")
            ->expectsOutputToContain("Dispatching $class...");

        Queue::assertPushed(\FakeJob::class);
    }
}
