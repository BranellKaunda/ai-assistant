<?php

namespace App\Console\Commands;

use App\Ai\Agents\PersonalAssistant;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:prompt {prompt? : The prompt to send to the assistant}')]
#[Description('Send a prompt to the personal assistant')]
class Prompt extends Command
{
    protected $signature = 'app:prompt';
    // structure of the command: php artisan app:prompt {prompt?} where prompt is an optional argument

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $prompt = $this->argument('prompt') ?? $this->ask('What would you like to ask?');
        //this is the argument from the command line, if not provided, it will ask the user for input

        $response = PersonalAssistant::make()->prompt($prompt);
        //prompt($prompt) is from Promptable trait in PersonalAssistant class

        $this->info($response->text);
    }
}
