<?php

namespace App\Http\Controllers;

use App\Models\studentmodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $students = Schema::hasTable('student')
            ? studentmodel::query()
                ->when($search !== '', function ($query) use ($search) {
                    $query->where(function ($innerQuery) use ($search) {
                        $innerQuery->where('student_id', 'like', "%{$search}%")
                            ->orWhere('f_name', 'like', "%{$search}%")
                            ->orWhere('l_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%")
                            ->orWhere('address', 'like', "%{$search}%")
                            ->orWhere('course', 'like', "%{$search}%")
                            ->orWhere('year', 'like', "%{$search}%");
                    });
                })
                ->latest('id')
                ->get()
            : collect();

        $studentCount = Schema::hasTable('student') ? studentmodel::count() : 0;

        return view('student', compact('students', 'studentCount', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateStudent($request, true);
        $validated['profile_image'] = $request->file('profile_image')->store('students', 'public');

        studentmodel::create($validated);

        return redirect()->route('student.index')->with('success', 'Student added successfully.');
    }

    public function edit(Request $request, string $id)
    {
        $editStudent = studentmodel::findOrFail($id);
        $search = trim((string) $request->query('search', ''));

        $students = studentmodel::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery->where('student_id', 'like', "%{$search}%")
                        ->orWhere('f_name', 'like', "%{$search}%")
                        ->orWhere('l_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        ->orWhere('course', 'like', "%{$search}%")
                        ->orWhere('year', 'like', "%{$search}%");
                });
            })
            ->latest('id')
            ->get();

        $studentCount = studentmodel::count();

        return view('student', compact('students', 'editStudent', 'studentCount', 'search'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $this->validateStudent($request, false);

        $student = studentmodel::findOrFail($id);

        if ($request->hasFile('profile_image')) {
            if ($student->profile_image) {
                Storage::disk('public')->delete($student->profile_image);
            }

            $validated['profile_image'] = $request->file('profile_image')->store('students', 'public');
        }

        $student->update($validated);

        return redirect()->route('student.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Request $request, string $id)
    {
        $student = studentmodel::findOrFail($id);

        if ($student->profile_image) {
            Storage::disk('public')->delete($student->profile_image);
        }

        $student->delete();

        return redirect()->route('student.index', array_filter([
            'search' => $request->input('search'),
        ], static fn ($value) => $value !== null && $value !== ''))
            ->with('success', 'Student deleted successfully.');
    }

    private function validateStudent(Request $request, bool $isCreate): array
    {
        $rules = [
            'student_id' => 'required|string|max:255',
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'year' => 'required|in:1st Year,2nd Year,3rd Year,4th Year',
            'profile_image' => ($isCreate ? 'required' : 'nullable') . '|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        return $request->validate($rules);
    }
}
