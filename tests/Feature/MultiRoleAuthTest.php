<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('login page is accessible to guests', function () {
    $response = $this->get(route('login'));

    $response->assertSuccessful();
    $response->assertSee('AmaliahSync');
    $response->assertSee('Masuk');
});

test('login requires email and password', function () {
    $response = $this->post(route('login'), []);

    $response->assertSessionHasErrors(['email', 'password']);
});

test('login fails with invalid credentials', function () {
    $user = User::factory()->student()->create([
        'email' => 'siswa@amaliah.sch.id',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->post(route('login'), [
        'email' => 'siswa@amaliah.sch.id',
        'password' => 'wrongpassword',
    ]);

    $response->assertSessionHasErrors(['email']);
    $this->assertGuest();
});

test('admin login redirects to admin dashboard', function () {
    $admin = User::factory()->admin()->create([
        'email' => 'admin@amaliah.sch.id',
        'password' => bcrypt('password'),
    ]);

    $response = $this->post(route('login'), [
        'email' => 'admin@amaliah.sch.id',
        'password' => 'password',
    ]);

    $response->assertRedirect(route('admin.dashboard'));
    $this->assertAuthenticatedAs($admin);
});

test('supervisor login redirects to supervisor dashboard', function () {
    $supervisor = User::factory()->supervisor()->create([
        'email' => 'guru@amaliah.sch.id',
        'password' => bcrypt('password'),
    ]);

    $response = $this->post(route('login'), [
        'email' => 'guru@amaliah.sch.id',
        'password' => 'password',
    ]);

    $response->assertRedirect(route('supervisor.dashboard'));
    $this->assertAuthenticatedAs($supervisor);
});

test('student login redirects to student dashboard', function () {
    $student = User::factory()->student()->create([
        'email' => 'siswa@amaliah.sch.id',
        'password' => bcrypt('password'),
    ]);

    $response = $this->post(route('login'), [
        'email' => 'siswa@amaliah.sch.id',
        'password' => 'password',
    ]);

    $response->assertRedirect(route('student.dashboard'));
    $this->assertAuthenticatedAs($student);
});

test('logout redirects to login page with success session message', function () {
    $user = User::factory()->student()->create();

    $response = $this->actingAs($user)->post(route('logout'));

    $response->assertRedirect(route('login'));
    $response->assertSessionHas('success');
    $this->assertGuest();
});

test('unauthenticated users cannot access role protected routes', function () {
    $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    $this->get(route('supervisor.dashboard'))->assertRedirect(route('login'));
    $this->get(route('student.dashboard'))->assertRedirect(route('login'));
});

test('role middleware forbids students from accessing admin routes', function () {
    $student = User::factory()->student()->create();

    $response = $this->actingAs($student)->get(route('admin.dashboard'));

    $response->assertForbidden();
});

test('role middleware forbids supervisors from accessing admin routes', function () {
    $supervisor = User::factory()->supervisor()->create();

    $response = $this->actingAs($supervisor)->get(route('admin.dashboard'));

    $response->assertForbidden();
});

test('role middleware forbids students from accessing supervisor routes', function () {
    $student = User::factory()->student()->create();

    $response = $this->actingAs($student)->get(route('supervisor.dashboard'));

    $response->assertForbidden();
});

test('authorized users can view their respective dashboards with main layout', function () {
    $admin = User::factory()->admin()->create(['name' => 'Admin Hubin']);
    $responseAdmin = $this->actingAs($admin)->get(route('admin.dashboard'));
    $responseAdmin->assertSuccessful();
    $responseAdmin->assertSee('Admin Hubin');
    $responseAdmin->assertSee('Mitra DUDI Aktif');

    $supervisor = User::factory()->supervisor()->create(['name' => 'Pak Guru Budi']);
    $responseSupervisor = $this->actingAs($supervisor)->get(route('supervisor.dashboard'));
    $responseSupervisor->assertSuccessful();
    $responseSupervisor->assertSee('Pak Guru Budi');

    $student = User::factory()->student()->create(['name' => 'Ahmad Fauzi']);
    $responseStudent = $this->actingAs($student)->get(route('student.dashboard'));
    $responseStudent->assertSuccessful();
    $responseStudent->assertSee('Ahmad Fauzi');
});
