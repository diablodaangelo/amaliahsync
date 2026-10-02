<?php

use App\Models\Attendance;
use App\Models\InternshipPlace;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('database seeder populates correct users, roles, places, attendances, and logs', function () {
    $this->seed(DatabaseSeeder::class);

    // Verify Admin
    $admin = User::where('email', 'admin@amaliah.sch.id')->first();
    expect($admin)->not->toBeNull();
    expect($admin->isAdmin())->toBeTrue();
    expect($admin->role)->toBe('admin');

    // Verify Supervisor
    $supervisor = User::where('email', 'guru@amaliah.sch.id')->first();
    expect($supervisor)->not->toBeNull();
    expect($supervisor->isSupervisor())->toBeTrue();
    expect($supervisor->role)->toBe('supervisor');

    // Verify Student
    $student = User::where('email', 'siswa@amaliah.sch.id')->first();
    expect($student)->not->toBeNull();
    expect($student->isStudent())->toBeTrue();
    expect($student->major)->toBe('RPL');
    expect($student->supervisor_id)->toBe($supervisor->id);
    expect($student->supervisor->id)->toBe($supervisor->id);

    // Verify Internship Places
    expect(InternshipPlace::count())->toBe(2);
    $telkom = InternshipPlace::where('name', 'like', '%Telkom%')->first();
    expect($telkom)->not->toBeNull();
    expect($student->internship_place_id)->toBe($telkom->id);
    expect($student->internshipPlace->id)->toBe($telkom->id);
    expect($telkom->students)->toHaveCount(1);

    // Verify Attendances
    expect($student->attendances)->toHaveCount(2);

    // Verify Internship Logs
    expect($student->internshipLogs)->toHaveCount(2);
});

test('attendances table enforces unique user_id and date constraint', function () {
    $student = User::factory()->student()->create();

    Attendance::create([
        'user_id' => $student->id,
        'date' => '2026-10-02',
        'status' => 'present',
    ]);

    expect(function () use ($student) {
        Attendance::create([
            'user_id' => $student->id,
            'date' => '2026-10-02',
            'status' => 'late',
        ]);
    })->toThrow(Exception::class);
});
