<?php

namespace App\Console\Commands;

use App\Mail\TempleListMail;
use App\Models\Temple;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TemplesReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:temples {--email=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Report of all temples';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Send a report of all temples
        $temples = Temple::all();
        // Mail the report to the user
        $sendToEmail = $this->option('email');
        if (!$sendToEmail) {
            return Command::FAILURE;
        }

        //Send one main list of all overdue books email to management
        Mail::to($sendToEmail)->send(new TempleListMail($temples));
        return Command::SUCCESS;
    }
}