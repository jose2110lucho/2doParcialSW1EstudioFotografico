<?php

namespace App\Console\Commands;

use App\Services\RekognitionService;
use Illuminate\Console\Command;

class AwsListFaces extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aws:list-faces';

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
        $response = $rkService->listFaces('users');
        if ($response['Status'] == 'success') {
            $this->line(count($response['Faces']) . ' Rostros registrados');
            foreach ($response['Faces'] as $face) {
                $this->line($face['FaceId']);
            }
        } else {
            $this->line($response['Message']);
        }
    }
}
