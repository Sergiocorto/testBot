<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class SendRequestToTrello extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-request-to-trello';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client();
        $headers = array(
            'Accept' => 'application/json'
        );

        $query = array(
            'name' => 'In progress',
            'key' => 'a586f1cd5a93ee92c41b8b0f6511ed79',
            'token' => 'ATTAb1b4a9f5cd66525dbb5c2b22f78354fa0676e0495f5f27ad68946a6fbeddcf69799A2048'
        );

        $client->post('https://api.trello.com/1/boards/64d8aeed4f6a3a5dfeb634f1/lists', [
            'headers' => $headers,
            'form_params' => $query
        ]);

        $query = array(
            'name' => 'Done',
            'key' => 'a586f1cd5a93ee92c41b8b0f6511ed79',
            'token' => 'ATTAb1b4a9f5cd66525dbb5c2b22f78354fa0676e0495f5f27ad68946a6fbeddcf69799A2048'
        );

        $client->post('https://api.trello.com/1/boards/64d8aeed4f6a3a5dfeb634f1/lists', [
            'headers' => $headers,
            'form_params' => $query
        ]);

        $this->info('Колонки створено');
    }
}
