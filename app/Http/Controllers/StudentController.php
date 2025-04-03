<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Stage;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['stage', 'grade', 'subjects'])
            ->orderBy('name', 'asc');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }

        $users = $query->paginate(10);

        $englishStages = Stage::with(['grades' => function ($query) {
            $query->whereHas('students.subjects', function ($q) {
                $q->where('subject', 'English');
            })->withCount(['students as english_students_count' => function ($query) {
                $query->whereHas('subjects', function ($q) {
                    $q->where('subject', 'English');
                });
            }]);
        }])->get();

        $technologyStages = Stage::with(['grades' => function ($query) {
            $query->whereHas('students.subjects', function ($q) {
                $q->where('subject', 'Technology');
            })->withCount(['students as technology_students_count' => function ($query) {
                $query->whereHas('subjects', function ($q) {
                    $q->where('subject', 'Technology');
                });
            }]);
        }])->get();

        return view('users.index', compact('englishStages', 'technologyStages', 'users'));
    }


    public function create()
    {
        $stages = Stage::all();
        $grades = Grade::all();
        $subjects = Subject::all();
        return view('users.create', compact('stages', 'grades', 'subjects'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->where(function ($query) use ($request) {
                    return $query->where('subject_id', $request->subject_id);
                }),
            ],
            'parent_phone' => 'required|string|max:255',
            'stage_id' => 'required|exists:stages,id',
            'grade_id' => 'required|exists:grades,id',
            'subject_id' => 'required|exists:subjects,id',
            'year' => 'nullable|string',
        ]);

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'Student created successfully!');
    }
    public function show($id)
    {
        $user = User::with(['stage', 'grade', 'subjects','rating'])->findOrFail($id);
        return view('users.show', compact('user'));
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $stages = Stage::all();
        $grades = Grade::all();
        $subjects = Subject::all();

        return view('users.edit', compact('user', 'stages', 'grades', 'subjects'));
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:255',
            'stage_id' => 'nullable|exists:stages,id',
            'grade_id' => 'nullable|exists:grades,id',
            'subject_id' => 'nullable|exists:subjects,id',
            'year' => 'nullable',
        ]);

        $user = User::findOrFail($id);
        $user->update($validated);
        return redirect()->route('users.index')->with('success', 'Student updated successfully!');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Student deleted successfully!');
    }

    public function showArchiveRecords(Request $request)
    {
        $fieldName = $request->input('field', null);
        $fieldValue = $request->input('data', null);
        
        [$archivedUsers, $metadata] = User::showArchive($fieldName, $fieldValue);
        
        return view('users.archive', compact('archivedUsers', 'metadata'));
    }
    
    public function restoreArchiveRecords(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer'
        ]);
    
        try {
            // Call the restoreArchive method from the ArchiveTrait
            $result = User::restoreArchive($request->ids);
            
            if ($result === true) {
                return response()->json([
                    'message' => count($request->ids) > 1 
                        ? 'Students have been restored successfully.' 
                        : 'Student has been restored successfully.'
                ]);
            } else {
                return response()->json(['message' => 'Failed to restore students.'], 500);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while restoring students.'], 500);
        }
    }
}
