@extends('layouts.master')

@section('title', 'Students | Student Information System')

@section('content')
    @php
        $isEditing = isset($editStudent);
        $searchTerm = $search ?? '';
        $filteredCount = $students->count();
        $hasSearch = trim($searchTerm) !== '';
    @endphp

    @if (session('success'))
        <div class="mb-6 rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-100">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-rose-400/20 bg-rose-400/10 px-4 py-3 text-sm text-rose-100">
            <p class="font-semibold">Please fix the following:</p>
            <ul class="mt-2 list-disc space-y-1 pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="grid gap-6">
        <aside id="student-form" class="rounded-[2rem] border border-white/10 bg-slate-900/80 p-6 shadow-2xl shadow-slate-950/30 backdrop-blur-xl sm:p-8">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-sky-300/90">Student form</p>
                    <h3 class="mt-2 text-2xl font-semibold text-white">{{ $isEditing ? 'Edit Student' : 'Add Student' }}</h3>
                </div>
                <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-medium text-slate-300">{{ $isEditing ? 'Update mode' : 'Create mode' }}</span>
            </div>

            <form action="{{ $isEditing ? route('student.update', $editStudent->id) : route('student.store') }}" method="post" enctype="multipart/form-data" class="mt-6 space-y-4">
                @csrf
                @if ($isEditing)
                    @method('PUT')
                @endif

                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="space-y-2 sm:col-span-2">
                        <span class="text-sm font-medium text-slate-200">Student ID</span>
                        <input type="text" name="student_id" value="{{ old('student_id', $editStudent->student_id ?? '') }}" placeholder="e.g. STU-1001" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-slate-400 focus:border-sky-400 focus:outline-none focus:ring-4 focus:ring-sky-400/15" required>
                    </label>

                    <label class="space-y-2 sm:col-span-2">
                        <span class="text-sm font-medium text-slate-200">Profile image</span>
                        <input type="file" name="profile_image" accept="image/*" class="w-full cursor-pointer rounded-2xl border border-dashed border-white/15 bg-white/5 px-4 py-3 text-sm text-slate-300 file:mr-4 file:rounded-xl file:border-0 file:bg-white file:px-4 file:py-2 file:text-sm file:font-semibold file:text-slate-900 hover:border-sky-400/60">
                        @if ($isEditing && $editStudent->profile_image)
                            <div class="flex items-center gap-3 rounded-2xl border border-white/10 bg-slate-950/40 p-3">
                                <img src="{{ asset('storage/' . $editStudent->profile_image) }}" alt="Current profile" class="h-14 w-14 rounded-xl object-cover">
                                <div>
                                    <p class="text-sm font-medium text-white">Current image</p>
                                    <p class="text-xs text-slate-400">Upload a new image to replace it.</p>
                                </div>
                            </div>
                        @endif
                    </label>

                    <label class="space-y-2">
                        <span class="text-sm font-medium text-slate-200">First name</span>
                        <input type="text" name="f_name" value="{{ old('f_name', $editStudent->f_name ?? '') }}" placeholder="First name" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-slate-400 focus:border-sky-400 focus:outline-none focus:ring-4 focus:ring-sky-400/15" required>
                    </label>

                    <label class="space-y-2">
                        <span class="text-sm font-medium text-slate-200">Last name</span>
                        <input type="text" name="l_name" value="{{ old('l_name', $editStudent->l_name ?? '') }}" placeholder="Last name" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-slate-400 focus:border-sky-400 focus:outline-none focus:ring-4 focus:ring-sky-400/15" required>
                    </label>

                    <label class="space-y-2 sm:col-span-2">
                        <span class="text-sm font-medium text-slate-200">Email</span>
                        <input type="email" name="email" value="{{ old('email', $editStudent->email ?? '') }}" placeholder="student@example.com" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-slate-400 focus:border-sky-400 focus:outline-none focus:ring-4 focus:ring-sky-400/15" required>
                    </label>

                    <label class="space-y-2">
                        <span class="text-sm font-medium text-slate-200">Phone</span>
                        <input type="text" name="phone" value="{{ old('phone', $editStudent->phone ?? '') }}" placeholder="Phone number" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-slate-400 focus:border-sky-400 focus:outline-none focus:ring-4 focus:ring-sky-400/15" required>
                    </label>

                    <label class="space-y-2">
                        <span class="text-sm font-medium text-slate-200">Course</span>
                        <input type="text" name="course" value="{{ old('course', $editStudent->course ?? '') }}" placeholder="Course" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-slate-400 focus:border-sky-400 focus:outline-none focus:ring-4 focus:ring-sky-400/15" required>
                    </label>

                    <label class="space-y-2 sm:col-span-2">
                        <span class="text-sm font-medium text-slate-200">Address</span>
                        <textarea name="address" rows="3" placeholder="Complete address" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-slate-400 focus:border-sky-400 focus:outline-none focus:ring-4 focus:ring-sky-400/15" required>{{ old('address', $editStudent->address ?? '') }}</textarea>
                    </label>

                    <label class="space-y-2 sm:col-span-2">
                        <span class="text-sm font-medium text-slate-200">Year level</span>
                        <select name="year" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white focus:border-sky-400 focus:outline-none focus:ring-4 focus:ring-sky-400/15" required>
                            <option value="" class="text-slate-900">Select Year</option>
                            @foreach (['1st Year', '2nd Year', '3rd Year', '4th Year'] as $yearOption)
                                <option value="{{ $yearOption }}" @selected(old('year', $editStudent->year ?? '') === $yearOption) class="text-slate-900">{{ $yearOption }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-sky-400 to-cyan-300 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:brightness-110">
                        {{ $isEditing ? 'Update student' : 'Save student' }}
                    </button>

                    @if ($isEditing)
                        <a href="{{ route('student.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-slate-200 transition hover:bg-white/10">Cancel</a>
                    @endif
                </div>
            </form>
        </aside>
    </section>

    <section id="student-table" class="mt-8 rounded-[2rem] border border-white/10 bg-white/8 p-4 shadow-2xl shadow-slate-950/30 backdrop-blur-xl sm:p-6 lg:p-8">
        <div class="flex flex-col gap-4 px-1 pb-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-300/90">Student list</p>
                <h3 class="mt-2 text-2xl font-semibold text-white">Current records</h3>
                <p class="mt-2 text-sm text-slate-400">
                    {{ $hasSearch ? 'Showing ' . $filteredCount . ' of ' . $studentCount . ' students for “' . $searchTerm . '”.' : 'Browse all student records below.' }}
                </p>
            </div>

            <form action="{{ route('student.index') }}" method="get" class="flex w-full flex-col gap-3 sm:flex-row lg:max-w-xl">
                <div class="relative flex-1">
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">Search</span>
                    <input
                        type="search"
                        name="search"
                        value="{{ $searchTerm }}"
                        placeholder="Search by ID, name, email, course..."
                        class="w-full rounded-2xl border border-white/10 bg-slate-950/70 py-3 pl-20 pr-4 text-white placeholder:text-slate-500 focus:border-sky-400 focus:outline-none focus:ring-4 focus:ring-sky-400/15"
                    >
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-sky-400 to-cyan-300 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:brightness-110">
                        Search
                    </button>
                    @if ($hasSearch)
                        <a href="{{ route('student.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-slate-200 transition hover:bg-white/10">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="max-h-[34rem] overflow-auto rounded-[1.5rem] border border-white/10">
            <table class="min-w-[1100px] divide-y divide-white/10 text-left text-sm">
                <thead class="sticky top-0 z-10 bg-slate-950/90 text-xs uppercase tracking-[0.22em] text-slate-300 backdrop-blur">
                    <tr>
                        <th class="px-4 py-4 font-semibold">Student ID</th>
                        <th class="px-4 py-4 font-semibold">Profile</th>
                        <th class="px-4 py-4 font-semibold">First name</th>
                        <th class="px-4 py-4 font-semibold">Last name</th>
                        <th class="px-4 py-4 font-semibold">Email</th>
                        <th class="px-4 py-4 font-semibold">Phone</th>
                        <th class="px-4 py-4 font-semibold">Address</th>
                        <th class="px-4 py-4 font-semibold">Course</th>
                        <th class="px-4 py-4 font-semibold">Year</th>
                        <th class="px-4 py-4 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10 bg-slate-900/60 text-slate-200">
                    @forelse ($students as $student)
                        <tr class="align-top transition hover:bg-white/5">
                            <td class="px-4 py-4 font-medium text-white">{{ $student->student_id }}</td>
                            <td class="px-4 py-4">
                                @if ($student->profile_image)
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('storage/' . $student->profile_image) }}" alt="{{ $student->f_name }} profile" class="h-16 w-16 shrink-0 rounded-2xl border border-white/10 object-cover shadow-lg shadow-slate-950/30">
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-white">{{ $student->f_name }} {{ $student->l_name }}</p>
                                            <p class="text-xs text-slate-400">Profile photo</p>
                                        </div>
                                    </div>
                                @else
                                    <span class="inline-flex items-center rounded-full border border-dashed border-white/15 px-3 py-2 text-xs text-slate-400">No image</span>
                                @endif
                            </td>
                            <td class="px-4 py-4">{{ $student->f_name }}</td>
                            <td class="px-4 py-4">{{ $student->l_name }}</td>
                            <td class="px-4 py-4">{{ $student->email }}</td>
                            <td class="px-4 py-4">{{ $student->phone }}</td>
                            <td class="px-4 py-4">{{ $student->address }}</td>
                            <td class="px-4 py-4">{{ $student->course }}</td>
                            <td class="px-4 py-4">{{ $student->year }}</td>
                            <td class="px-4 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('student.edit', array_merge(['id' => $student->id], request()->query())) }}" class="inline-flex items-center rounded-full bg-sky-400/15 px-3 py-1.5 text-xs font-semibold text-sky-200 transition hover:bg-sky-400/25">Edit</a>
                                    <form action="{{ route('student.destroy', $student->id) }}" method="post" class="inline-flex">
                                        @csrf
                                        @method('DELETE')
                                        @foreach (request()->except('_token', '_method') as $key => $value)
                                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                        @endforeach
                                        <button type="submit" onclick="return confirm('Delete this student?')" class="inline-flex items-center rounded-full bg-rose-400/15 px-3 py-1.5 text-xs font-semibold text-rose-200 transition hover:bg-rose-400/25">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-4 py-12 text-center text-slate-400">No students found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
