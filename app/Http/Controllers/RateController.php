<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use App\Models\Subject;
use App\Models\Stage;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Http\Request;

class RateController extends Controller
{

    public function edit(Rate $rate)
    {
        $subjects = Subject::all();
        return view('rates.edit', compact('rate', 'subjects'));
    }
    public function update(Request $request, Rate $rate)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'rate' => 'required|integer|min:1|max:5',
            'notes' => 'nullable|string|max:500',
        ]);

        $rate->update($validated);

        return redirect()->route('students.show', $rate->student)
            ->with('success', 'Rating updated successfully.');
    }

    public function destroy($id)
    {
        $rate=Rate::findOrFail($id);
        $rate->delete();
        return back()->with('success', 'Rating deleted successfully.');
    }

    public function selectSubject()
    {
        $subjects = Subject::all();
        return view('rates.select-subject', compact('subjects'));
    }

    public function selectStage(Subject $subject)
    {
        $stages = Stage::all();
        return view('rates.select-stage', compact('subject', 'stages'));
    }
    public function selectGrade(Subject $subject, Stage $stage)
    {
        return view('rates.select-grade', compact('subject', 'stage'));
    }

    public function showStudents(Subject $subject, Stage $stage, Grade $grade)
    {
        $students = $grade->students()
            ->where('subject_id', $subject->id)
            ->with(['rating' => function ($query) use ($subject) {
                $query->where('subject_id', $subject->id);
            }])
            ->get();

        return view('rates.select-student', compact('subject', 'stage', 'grade', 'students'));
    }
    public function create(Subject $subject, Stage $stage, Grade $grade, User $student)
    {
        $existingRating = Rate::where([
            'user_id' => $student->id,
            'subject_id' => $subject->id,
        ])->first();

        return view('rates.create', compact('subject', 'stage', 'grade', 'student', 'existingRating'));
    }

    public function store(Request $request, Subject $subject, Stage $stage, Grade $grade, User $student)
    {
        $validated = $request->validate([
            'rate' => 'nullable|integer|min:1|max:5',
            'notes' => 'nullable|string|max:500',
        ]);

        $rate=Rate::updateOrCreate(
            [
                'user_id' => $student->id,
                'subject_id' => $subject->id,
            ],
            [
                'rate' => $validated['rate'],
                'notes' => $validated['notes'] ,
            ]
        );
        if(!$rate) {
            return back()->with('error', 'Failed to rate the student.');
        }
        return redirect()->route('rates.show-students', [$subject, $stage, $grade])
            ->with('success', 'Student rated successfully!');
    }
}
