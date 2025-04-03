<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        return view('subjects.index', compact('subjects'));
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);

        return view('subjects.edit', compact('subject'));
    }

    public function update(Request $request, $id)
    {
        Log::info('Updating subject with ID: ' . $id);
        $subject = Subject::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subject->update([
            "subject" => $validated['name']
        ]);
        $subject->save();
        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully.');
    }

    public function showSubjectDetails(Request $request, $subject_id)
    {
        $subject = Subject::findOrFail($subject_id);

        $query = User::where('subject_id', $subject_id)
            ->with(['stage', 'grade'])
            ->orderBy('name', 'desc');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $users = $query->paginate(10);

        $stages = User::where('subject_id', $subject_id)
            ->with('stage')
            ->get()
            ->groupBy(function ($user) {
                return $user->stage->name ?? 'Unknown';
            });

        return view('subjects.details', compact('users', 'stages', 'subject'));
    }

    public function getGrades($stageId)
    {
        $grades = Grade::where('stage_id', $stageId)->get(['id', 'name']);
        return response()->json($grades);
    }
}
