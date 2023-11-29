<?php

namespace App\Console\Commands;

use App\Services\RekognitionService;
use Illuminate\Console\Command;

class AwsResetCollection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aws:reset-collection';

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
        $rkService = new RekognitionService();
        $response = $rkService->deleteCollection('users');
        if ($response['Status'] == 'success') {
            $this->info($response['Message']);
            $response = $rkService->createCollection('users');
            if ($response['Status'] == 'success') {
                $this->info($response['Message']);
            } else {
                $this->error($response['Message']);
            }
        } else {
            $this->error($response['Message']);
        }
    }
}
