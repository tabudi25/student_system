<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Student Information System'))</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-shell">
    <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(244,114,182,0.14),_transparent_30%),radial-gradient(circle_at_top_right,_rgba(59,130,246,0.14),_transparent_28%)]"></div>
    <div class="relative min-h-screen">
        <header class="sticky top-0 z-50 border-b border-white/10 bg-slate-950/75 backdrop-blur-xl">
            <div class="mx-auto flex w-full max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                <a href="{{ route('student.index') }}" class="flex items-center gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-rose-400 to-orange-300 text-sm font-bold text-slate-950 shadow-lg shadow-rose-500/20">SI</span>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Southern Philippines college</p>
                        <h1 class="text-lg font-semibold text-white">Student Information System</h1>
                    </div>
                </a>

                <button type="button" data-nav-toggle aria-expanded="false" aria-controls="primary-navigation" class="inline-flex items-center justify-center rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold text-slate-200 transition hover:bg-white/10 md:hidden">
                    Menu
                </button>

                <nav id="primary-navigation" data-nav-panel class="hidden w-full flex-col gap-2 pt-4 md:flex md:w-auto md:flex-row md:items-center md:gap-2 md:pt-0">
                    <a href="{{ route('student.index') }}" class="nav-link {{ request()->routeIs('student.index') ? 'nav-link-active' : '' }}">Students</a>
                    <a href="#student-form" class="nav-link">Add Student</a>
                    <a href="#student-table" class="nav-link">Records</a>
                </nav>
            </div>
        </header>

        <main class="relative mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 lg:px-8 lg:py-10">
            @yield('content')
        </main>
    </div>
</body>
</html>