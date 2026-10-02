@extends('layouts.main')

@section('title', 'Dashboard Admin Hubin - AmaliahSync')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-purple-700 to-indigo-600 rounded-2xl p-6 text-white shadow-lg">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/20 text-white backdrop-blur-sm mb-2">
                    👑 Administrator Hubungan Industri (Hubin)
                </span>
                <h1 class="text-2xl font-extrabold tracking-tight">Selamat Datang, {{ auth()->user()->name }}!</h1>
                <p class="text-purple-100 text-sm mt-1">
                    Kelola data master DUDI mitra, plotting siswa PKL, dan akun guru pembimbing SMK Amaliah.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.places.index') }}" class="px-4 py-2 bg-white text-purple-900 font-bold text-xs rounded-xl shadow-xs hover:bg-purple-50 transition-colors">
                    Kelola DUDI &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs">
            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Mitra DUDI Aktif</div>
            <div class="text-3xl font-extrabold text-slate-900 mt-2">{{ \App\Models\InternshipPlace::count() }}</div>
            <div class="text-xs text-emerald-600 mt-1">Perusahaan / Kantor</div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs">
            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Siswa Terdaftar</div>
            <div class="text-3xl font-extrabold text-slate-900 mt-2">{{ \App\Models\User::where('role', 'student')->count() }}</div>
            <div class="text-xs text-blue-600 mt-1">8 Jurusan Keahlian</div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs">
            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Guru Pembimbing</div>
            <div class="text-3xl font-extrabold text-slate-900 mt-2">{{ \App\Models\User::where('role', 'supervisor')->count() }}</div>
            <div class="text-xs text-purple-600 mt-1">Guru Aktif</div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs">
            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Geofence GPS Engine</div>
            <div class="text-3xl font-extrabold text-emerald-600 mt-2">Active</div>
            <div class="text-xs text-slate-500 mt-1">Haversine Formula Validated</div>
        </div>
    </div>
</div>
@endsection
