<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\InternshipLog;
use App\Models\InternshipPlace;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Internship Places (DUDI)
        $telkom = InternshipPlace::create([
            'name' => 'PT Telkom Indonesia (Witel Bogor)',
            'address' => 'Jl. Raya Pajajaran No. 37, Babakan, Kec. Bogor Tengah, Kota Bogor, Jawa Barat 16128',
            'latitude' => -6.5976288,
            'longitude' => 106.8048256,
            'radius_meters' => 60,
            'start_time' => '08:00:00',
            'end_time' => '16:30:00',
        ]);

        $technoMedia = InternshipPlace::create([
            'name' => 'CV Techno Media Kreatif',
            'address' => 'Jl. Raya Puncak Gadog No. 45, Ciawi, Kabupaten Bogor, Jawa Barat 16720',
            'latitude' => -6.6578000,
            'longitude' => 106.8525000,
            'radius_meters' => 50,
            'start_time' => '07:30:00',
            'end_time' => '16:00:00',
        ]);

        // 2. Seed Administrator (Hubin)
        $admin = User::create([
            'name' => 'Administrator Hubin',
            'nickname' => 'Admin',
            'email' => 'admin@amaliah.sch.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'major' => null,
            'bio' => 'Koordinator Hubungan Industri (Hubin) SMK Amaliah 1 & 2 Ciawi.',
        ]);

        // 3. Seed Supervisor (Guru Pembimbing)
        $supervisor = User::create([
            'name' => 'Budi Santoso, S.Kom.',
            'nickname' => 'Pak Budi',
            'email' => 'guru@amaliah.sch.id',
            'password' => Hash::make('password'),
            'role' => 'supervisor',
            'major' => null,
            'bio' => 'Guru Pembimbing PKL Kompetensi Keahlian RPL & TKJ SMK Amaliah.',
        ]);

        // 4. Seed Student (Siswa RPL)
        $student = User::create([
            'name' => 'Ahmad Fauzi',
            'nickname' => 'Fauzi',
            'email' => 'siswa@amaliah.sch.id',
            'password' => Hash::make('password'),
            'role' => 'student',
            'major' => 'RPL',
            'bio' => 'Siswa RPL SMK Amaliah 1 Ciawi, fokus pada Web Development & Database.',
            'supervisor_id' => $supervisor->id,
            'internship_place_id' => $telkom->id,
        ]);

        // 5. Seed Initial Attendance Records for Student
        // Hari pertama (2 hari lalu - Terlambat)
        Attendance::create([
            'user_id' => $student->id,
            'date' => Carbon::now()->subDays(2)->toDateString(),
            'check_in' => '08:15:00',
            'check_out' => '16:30:00',
            'latitude' => -6.5976200,
            'longitude' => 106.8048200,
            'photo_in' => null,
            'photo_out' => null,
            'status' => 'late',
        ]);

        // Hari kedua (1 hari lalu - Tepat Waktu)
        Attendance::create([
            'user_id' => $student->id,
            'date' => Carbon::now()->subDay()->toDateString(),
            'check_in' => '07:50:00',
            'check_out' => '16:35:00',
            'latitude' => -6.5976250,
            'longitude' => 106.8048230,
            'photo_in' => null,
            'photo_out' => null,
            'status' => 'present',
        ]);

        // 6. Seed Initial Internship Logs for Student
        InternshipLog::create([
            'user_id' => $student->id,
            'date' => Carbon::now()->subDays(2)->toDateString(),
            'title' => 'Instalasi dan Konfigurasi Web Server Nginx',
            'description' => 'Melakukan konfigurasi reverse proxy Nginx pada server internal divisi IT Network PT Telkom Witel Bogor.',
            'documentation_file' => null,
            'status' => 'approved',
            'feedback' => 'Pekerjaan sangat baik dan rapi. Lanjutkan pendokumentasian topologi jaringannya.',
        ]);

        InternshipLog::create([
            'user_id' => $student->id,
            'date' => Carbon::now()->subDay()->toDateString(),
            'title' => 'Pemeliharaan Database MySQL dan Backup Rutin',
            'description' => 'Mengecek status replication database MySQL dan menjalankan script backup data log jaringan harian.',
            'documentation_file' => null,
            'status' => 'pending',
            'feedback' => null,
        ]);
    }
}
