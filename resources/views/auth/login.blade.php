<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - AmaliahSync | Monitoring PKL SMK Amaliah</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-gradient-to-br from-slate-100 via-emerald-50/40 to-slate-100">

    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <!-- Logo & Title -->
        <div class="flex justify-center">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white font-black text-3xl shadow-xl shadow-emerald-500/25">
                A
            </div>
        </div>
        <h2 class="mt-4 text-center text-2xl font-extrabold tracking-tight text-slate-900">
            Amaliah<span class="text-emerald-600">Sync</span>
        </h2>
        <p class="mt-1 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">
            Sistem Monitoring PKL &bull; SMK Amaliah 1 & 2 Ciawi
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md px-4 sm:px-0">
        <div class="bg-white py-8 px-6 sm:px-10 shadow-xl shadow-slate-200/50 rounded-2xl border border-slate-200/80">

            <!-- Flash Alert -->
            @if (session('success'))
                <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 p-3.5 text-xs text-emerald-800 flex items-center gap-2">
                    <span class="font-bold">✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-rose-200 bg-rose-50 p-3.5 text-xs text-rose-800">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Alamat Email
                    </label>
                    <div class="mt-1.5 relative">
                        <input id="email" name="email" type="email" autocomplete="email" required
                            value="{{ old('email') }}"
                            placeholder="nama@amaliah.sch.id"
                            class="block w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 shadow-xs placeholder:text-slate-400 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 @error('email') border-rose-500 @enderror">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Kata Sandi
                    </label>
                    <div class="mt-1.5">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            placeholder="••••••••"
                            class="block w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 shadow-xs placeholder:text-slate-400 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 @error('password') border-rose-500 @enderror">
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 cursor-pointer select-none text-slate-600">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded text-emerald-600 border-slate-300 focus:ring-emerald-500">
                        <span>Ingat saya</span>
                    </label>
                    <span class="text-slate-400">Default pass: <code class="text-emerald-700 font-mono font-bold">password</code></span>
                </div>

                <button type="submit"
                    class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all">
                    Masuk ke Sistem
                </button>
            </form>

            <!-- Quick Auto-Fill Demo Accounts -->
            <div class="mt-6 pt-6 border-t border-slate-100">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center mb-3">
                    Akses Cepat Pengujian (1-Klik)
                </p>
                <div class="grid grid-cols-3 gap-2">
                    <button type="button" onclick="fillLogin('admin@amaliah.sch.id', 'password')"
                        class="p-2 rounded-lg border border-purple-200 bg-purple-50/60 hover:bg-purple-100 text-purple-900 text-center transition-colors">
                        <div class="text-xs font-bold">👑 Admin</div>
                        <div class="text-[10px] text-purple-600 truncate">Hubin</div>
                    </button>
                    <button type="button" onclick="fillLogin('guru@amaliah.sch.id', 'password')"
                        class="p-2 rounded-lg border border-blue-200 bg-blue-50/60 hover:bg-blue-100 text-blue-900 text-center transition-colors">
                        <div class="text-xs font-bold">👨‍🏫 Guru</div>
                        <div class="text-[10px] text-blue-600 truncate">Pembimbing</div>
                    </button>
                    <button type="button" onclick="fillLogin('siswa@amaliah.sch.id', 'password')"
                        class="p-2 rounded-lg border border-emerald-200 bg-emerald-50/60 hover:bg-emerald-100 text-emerald-900 text-center transition-colors">
                        <div class="text-xs font-bold">🎓 Siswa</div>
                        <div class="text-[10px] text-emerald-600 truncate">RPL</div>
                    </button>
                </div>
            </div>

        </div>

        <p class="text-center text-xs text-slate-400 mt-6">
            &copy; {{ date('Y') }} SMK Amaliah 1 & 2 Ciawi Bogor &bull; Presensi & Jurnal PKL
        </p>
    </div>

    <script>
        function fillLogin(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }
    </script>
</body>
</html>
