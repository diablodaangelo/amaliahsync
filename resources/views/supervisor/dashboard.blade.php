@extends('layouts.main')

@section('title', 'Dashboard Guru Pembimbing - AmaliahSync')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-blue-700 to-sky-600 rounded-2xl p-6 text-white shadow-lg">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/20 text-white backdrop-blur-sm mb-2">
                    👨‍🏫 Guru Pembimbing PKL
                </span>
                <h1 class="text-2xl font-extrabold tracking-tight">Selamat Datang, {{ auth()->user()->name }}!</h1>
                <p class="text-blue-100 text-sm mt-1">
                    Pantau kehadiran fisik siswa dan lakukan review serta persetujuan jurnal harian bimbingan Anda.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('supervisor.attendances.index') }}" class="px-4 py-2 bg-white text-blue-900 font-bold text-xs rounded-xl shadow-xs hover:bg-blue-50 transition-colors">
                    Monitoring Absensi &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs">
            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Siswa Bimbingan</div>
            <div class="text-3xl font-extrabold text-slate-900 mt-2">{{ auth()->user()->students()->count() }}</div>
            <div class="text-xs text-blue-600 mt-1">Siswa Aktif di DUDI</div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs">
            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Jurnal Menunggu Review</div>
            <div class="text-3xl font-extrabold text-amber-600 mt-2">
                {{ \App\Models\InternshipLog::whereIn('user_id', auth()->user()->students()->pluck('id'))->where('status', 'pending')->count() }}
            </div>
            <div class="text-xs text-slate-500 mt-1">Perlu Verifikasi & Feedback</div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs">
            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Presensi Hari Ini</div>
            <div class="text-3xl font-extrabold text-emerald-600 mt-2">
                {{ \App\Models\Attendance::whereIn('user_id', auth()->user()->students()->pluck('id'))->where('date', now()->toDateString())->count() }}
            </div>
            <div class="text-xs text-slate-500 mt-1">Tercatat Hadir</div>
        </div>
    </div>
</div>
@endsection
