<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use BigQuery;

class DeployBigQueryProcedures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bq:deploy-sp {name? : Nama spesifik file SP yang ingin di-deploy (tanpa format .sql)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy semua atau satu BigQuery Stored Procedure dari file lokal .sql ke cloud';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dirPath = database_path('bigquery/stored_procedures');

        if (!File::isDirectory($dirPath)) {
            $this->error("Direktori tidak ditemukan: $dirPath");
            $this->info("Silakan buat folder 'database/bigquery/stored_procedures' dan masukkan file .sql Anda.");
            return 1;
        }

        $specificName = $this->argument('name');
        $files = File::files($dirPath);

        $filesToDeploy = [];
        foreach ($files as $file) {
            if ($file->getExtension() !== 'sql') {
                continue;
            }
            
            // Jika user mengisi argument {name}, kita filter nama file-nya saja
            if ($specificName && $file->getFilenameWithoutExtension() !== $specificName) {
                continue;
            }
            $filesToDeploy[] = $file;
        }

        if (empty($filesToDeploy)) {
            $this->info("Tidak ada file SQL yang ditemukan untuk di-deploy.");
            return 0;
        }

        $this->info('Memulai deployment ' . count($filesToDeploy) . ' Stored Procedure ke BigQuery...');

        // Samakan lokasi region dengan yang ada di BigQueryController
        $location = 'asia-southeast2'; 

        foreach ($filesToDeploy as $file) {
            $fileName = $file->getFilename();
            $this->line("Meng-deploy: <info>$fileName</info>...");

            $query = File::get($file->getPathname());

            try {
                // Menjalankan query DDL (Data Definition Language) -> CREATE OR REPLACE PROCEDURE
                $jobConfig = BigQuery::query($query);
                $jobConfig->location($location);
                $job = BigQuery::startQuery($jobConfig);

                $job->waitUntilComplete();
                
                $jobInfo = $job->info();
                if (isset($jobInfo['status']['errorResult'])) {
                     $this->error("Gagal men-deploy $fileName: " . ($jobInfo['status']['errorResult']['message'] ?? 'Error tidak diketahui'));
                } else {
                     $this->info("Berhasil men-deploy $fileName \xE2\x9C\x94");
                }
            } catch (\Exception $e) {
                $this->error("Exception saat men-deploy $fileName: " . $e->getMessage());
            }
            
            $this->line("--------------------------------------------------");
        }

        $this->info('Proses deployment selesai.');
        return 0;
    }
}
