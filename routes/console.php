<?php

use Illuminate\Support\Facades\Schedule;
use Laravel\Telescope\Console\PruneCommand;

Schedule::command(PruneCommand::class)
    ->daily();
