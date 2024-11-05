<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExportDatabase extends Command
{
    protected $signature = 'db:export {filename?}';
    protected $description = 'Export database to a SQL file';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Ambil konfigurasi database dari .env
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $dbHost = env('DB_HOST') ?? '127.0.0.1'; // Tambahkan nilai default jika DB_HOST kosong
        $filename = $this->argument('filename') ?? 'backup.sql';

        // Tentukan perintah untuk mengeksport database
        $command = "mysqldump -u$dbUser -p$dbPass -h$dbHost $dbName > $filename";

        // Jalankan perintah
        $output = null;
        $resultCode = null;
        exec($command, $output, $resultCode);

        if ($resultCode === 0) {
            $this->info("Database has been exported to $filename");
        } else {
            $this->error("Failed to export database. Please check the database configuration.");
        }
    }
}
