<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'AmaliahSync - Monitoring PKL SMK Amaliah')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (via CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        amaliah: {
                            green: '#047857',
                            emerald: '#059669',
                            teal: '#0d9488',
                            dark: '#064e3b',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>

    @stack('styles')
</head>
<body class="min-h-full flex flex-col text-slate-800 antialiased selection:bg-brand-500 selection:text-white">

    <!-- Top Navigation Bar -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Brand / Logo -->
                <div class="flex items-center gap-3">
                    <a href="{{ auth()->check() ? app(\App\Http\Controllers\AuthController::class)->redirectPathForUser(auth()->user()) : url('/') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white font-black text-xl shadow-md shadow-emerald-500/20 group-hover:scale-105 transition-transform">
                            A
                        </div>
                        <div>
                            <div class="text-base font-extrabold tracking-tight text-slate-900 group-hover:text-emerald-600 transition-colors">
                                Amaliah<span class="text-emerald-600">Sync</span>
                            </div>
                            <div class="text-[10px] font-semibold tracking-wider text-slate-400 uppercase">
                                SMK Amaliah 1 & 2 Ciawi
                            </div>
                        </div>
                    </a>

                    <!-- Desktop Nav Links -->
                    @auth
                        <div class="hidden md:flex md:items-center md:gap-1 md:ml-8 border-l border-slate-200 pl-6">
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.dashboard*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                    Dashboard
                                </a>
                                <a href="{{ route('admin.places.index') }}" class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.places*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                    Master DUDI
                                </a>
                                <a href="{{ route('admin.students.index') }}" class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.students*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                    Siswa PKL
                                </a>
                                <a href="{{ route('admin.supervisors.index') }}" class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.supervisors*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                    Guru Pembimbing
                                </a>
                            @elseif(auth()->user()->isSupervisor())
                                <a href="{{ route('supervisor.dashboard') }}" class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('supervisor.dashboard*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                    Dashboard
                                </a>
                                <a href="{{ route('supervisor.attendances.index') }}" class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('supervisor.attendances*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                    Monitoring Absensi
                                </a>
                                <a href="{{ route('supervisor.logs.index') }}" class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('supervisor.logs*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                    Review Jurnal
                                </a>
                            @elseif(auth()->user()->isStudent())
                                <a href="{{ route('student.dashboard') }}" class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('student.dashboard*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                    Dashboard
                                </a>
                                <a href="{{ route('student.attendance.index') }}" class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('student.attendance*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                    Presensi GPS
                                </a>
                                <a href="{{ route('student.logs.index') }}" class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('student.logs*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                    Jurnal Harian
                                </a>
                                <a href="{{ route('student.profile') }}" class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('student.profile*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                    Profil
                                </a>
                            @endif
                        </div>
                    @endauth
                </div>

                <!-- Right Nav Profile & Logout -->
                <div class="flex items-center gap-3">
                    @auth
                        <div class="flex items-center gap-3">
                            <div class="hidden sm:flex sm:flex-col sm:items-end text-right">
                                <span class="text-sm font-bold text-slate-800 leading-tight">{{ auth()->user()->name }}</span>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    @if(auth()->user()->isAdmin())
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-purple-100 text-purple-800">
                                            Admin Hubin
                                        </span>
                                    @elseif(auth()->user()->isSupervisor())
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-blue-100 text-blue-800">
                                            Guru Pembimbing
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-100 text-emerald-800">
                                            Siswa &bull; {{ auth()->user()->major ?? 'PKL' }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Avatar -->
                            <div class="w-9 h-9 rounded-full bg-slate-200 border-2 border-slate-300 flex items-center justify-center font-bold text-sm text-slate-600">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>

                            <!-- Logout Button -->
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" title="Logout" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 rounded-lg transition-colors border border-rose-200">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    <span class="hidden sm:inline">Keluar</span>
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-xs transition-colors">
                            Masuk
                        </a>
                    @endauth

                    <!-- Mobile Menu Button -->
                    @auth
                        <button type="button" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="md:hidden p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        @auth
            <div id="mobile-menu" class="hidden md:hidden border-t border-slate-200 bg-white px-4 pt-2 pb-4 space-y-1">
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 hover:bg-slate-100">Dashboard</a>
                    <a href="{{ route('admin.places.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 hover:bg-slate-100">Master DUDI</a>
                    <a href="{{ route('admin.students.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 hover:bg-slate-100">Siswa PKL</a>
                    <a href="{{ route('admin.supervisors.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 hover:bg-slate-100">Guru Pembimbing</a>
                @elseif(auth()->user()->isSupervisor())
                    <a href="{{ route('supervisor.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 hover:bg-slate-100">Dashboard</a>
                    <a href="{{ route('supervisor.attendances.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 hover:bg-slate-100">Monitoring Absensi</a>
                    <a href="{{ route('supervisor.logs.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 hover:bg-slate-100">Review Jurnal</a>
                @elseif(auth()->user()->isStudent())
                    <a href="{{ route('student.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 hover:bg-slate-100">Dashboard</a>
                    <a href="{{ route('student.attendance.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 hover:bg-slate-100">Presensi GPS</a>
                    <a href="{{ route('student.logs.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 hover:bg-slate-100">Jurnal Harian</a>
                    <a href="{{ route('student.profile') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 hover:bg-slate-100">Profil Saya</a>
                @endif
            </div>
        @endauth
    </nav>

    <!-- Flash Notifications Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pt-4">
        @if (session('success'))
            <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 flex items-center justify-between shadow-xs" role="alert">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-200 text-emerald-800 font-bold text-xs">✓</span>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.closest('[role=alert]').remove()" class="text-emerald-600 hover:text-emerald-900 font-bold text-lg leading-none">&times;</button>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800 flex items-center justify-between shadow-xs" role="alert">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-rose-200 text-rose-800 font-bold text-xs">!</span>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.closest('[role=alert]').remove()" class="text-rose-600 hover:text-rose-900 font-bold text-lg leading-none">&times;</button>
            </div>
        @endif
    </div>

    <!-- Main Dynamic Content -->
    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    <!-- Footer -->
    <footer class="mt-auto border-t border-slate-200 bg-white py-4 text-center text-xs text-slate-500">
        <p>&copy; {{ date('Y') }} SMK Amaliah 1 & 2 Ciawi Bogor &bull; AmaliahSync v2.0</p>
    </footer>

    @stack('scripts')
</body>
</html>
