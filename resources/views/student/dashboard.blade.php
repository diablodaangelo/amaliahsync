@extends('layouts.main')

@section('title', 'Dashboard Siswa PKL - AmaliahSync')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-emerald-700 to-teal-600 rounded-2xl p-6 text-white shadow-lg">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/20 text-white backdrop-blur-sm mb-2">
                    🎓 Siswa PKL &bull; {{ auth()->user()->major ?? 'Jurusan Kejuruan' }}
                </span>
                <h1 class="text-2xl font-extrabold tracking-tight">Halo, {{ auth()->user()->nickname ?? auth()->user()->name }}!</h1>
                <p class="text-emerald-100 text-sm mt-1">
                    {{ auth()->user()->internshipPlace ? auth()->user()->internshipPlace->name : 'Belum diplot ke DUDI' }}
                    @if(auth()->user()->supervisor)
                        &bull; Pembimbing: {{ auth()->user()->supervisor->name }}
                    @endif
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('student.attendance.index') }}" class="px-4 py-2 bg-white text-emerald-900 font-bold text-xs rounded-xl shadow-xs hover:bg-emerald-50 transition-colors">
                    Presensi Sekarang &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs">
            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Kehadiran</div>
            <div class="text-3xl font-extrabold text-slate-900 mt-2">{{ auth()->user()->attendances()->count() }}</div>
            <div class="text-xs text-emerald-600 mt-1">Hari Terdata</div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs">
            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Jurnal Dikirim</div>
            <div class="text-3xl font-extrabold text-blue-600 mt-2">{{ auth()->user()->internshipLogs()->count() }}</div>
            <div class="text-xs text-slate-500 mt-1">Laporan Kegiatan</div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs">
            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Status Bimbingan</div>
            <div class="text-3xl font-extrabold text-purple-600 mt-2">Aktif</div>
            <div class="text-xs text-slate-500 mt-1">SMK Amaliah 1 & 2 Ciawi</div>
        </div>
    </div>
</div>
@endsection
