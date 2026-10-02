<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

#[Signature('app:verify-setup')]
#[Description('Verifikasi koneksi database MySQL, konfigurasi timezone Asia/Jakarta, locale, dan storage')]
class VerifySetupCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('=========================================');
        $this->info('  AmaliahSync Environment Verification  ');
        $this->info('=========================================');

        $isOk = true;

        // 1. Database Connection Check
        try {
            $pdo = DB::connection()->getPdo();
            $dbName = DB::connection()->getDatabaseName();
            $driver = DB::connection()->getDriverName();
            $this->components->twoColumnDetail('Database Connection', '<fg=green;options=bold>CONNECTED</>');
            $this->components->twoColumnDetail('Database Driver / Name', "{$driver} / {$dbName}");
        } catch (\Throwable $e) {
            $isOk = false;
            $this->components->twoColumnDetail('Database Connection', '<fg=red;options=bold>FAILED</>');
            $this->error('Error: '.$e->getMessage());
        }

        // 2. Timezone & Current Time Check
        $timezone = config('app.timezone');
        $currentTime = now()->toDateTimeString();
        $isTimezoneWib = $timezone === 'Asia/Jakarta';

        $this->components->twoColumnDetail(
            'Application Timezone',
            $isTimezoneWib ? "<fg=green;options=bold>{$timezone}</>" : "<fg=yellow;options=bold>{$timezone}</>"
        );
        $this->components->twoColumnDetail('Current Timestamp (WIB)', $currentTime);

        // 3. Locale Check
        $locale = config('app.locale');
        $fallbackLocale = config('app.fallback_locale');
        $this->components->twoColumnDetail('Application Locale', "{$locale} (fallback: {$fallbackLocale})");

        // 4. Storage Link Check
        $storageLinked = File::exists(public_path('storage'));
        $this->components->twoColumnDetail(
            'Storage Link (public/storage)',
            $storageLinked ? '<fg=green;options=bold>LINKED</>' : '<fg=yellow;options=bold>MISSING</>'
        );

        $this->newLine();
        if ($isOk) {
            $this->info(' Semua verifikasi dasar FASE 1 berhasil!');

            return Command::SUCCESS;
        }

        $this->error(' Ada konfigurasi yang belum terpenuhi.');

        return Command::FAILURE;
    }
}
