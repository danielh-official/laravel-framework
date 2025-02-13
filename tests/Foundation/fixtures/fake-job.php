<?php

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class FakeJob implements ShouldQueue
{
    use Queueable;

    public function handle()
    {

    }
}
