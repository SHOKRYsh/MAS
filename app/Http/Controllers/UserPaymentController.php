<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\Subject;
use App\Models\User;
use App\Models\Stage;
use App\Models\Grade;
use App\Models\UserPayment;
use Illuminate\Http\Request;

class UserPaymentController extends Controller
{
    public function index()
    {
        $payments = UserPayment::with(['user', 'subject'])->latest()->paginate();
        return view('payments.index', compact('payments'));
    }

    public function edit(User $student)
    {
        $payment = UserPayment::where('user_id', $student->id)
            ->where('subject_id', $student->subject_id)
            ->latest()
            ->first();
        return view('payments.edit', compact('payment', 'student'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000|max:' . now()->year,
            'status' => 'required|boolean',
        ]);

        $payment = UserPayment::findOrFail($id);
        $payment->update($request->all());
        $user = User::findOrFail($request->user_id);
        $subject = Subject::findOrFail($request->subject_id);
        $stage = $user->stage;
        $grade = $user->grade;
        return redirect()->route('payments.show-students', [
            'subject' => $subject->id,
            'stage' => $stage->id,
            'grade' => $grade->id
        ])->with('success', 'Payment record updated successfully!');
    }

    public function destroy($id)
    {
        $payment = UserPayment::findOrFail($id);
        $payment->delete();

        return redirect()->route('payments.index')->with('success', 'Payment record deleted successfully!');
    }

    public function unpaidUsers(Subject $subject, Stage $stage, Grade $grade, Request $request)
    {
        $request->validate([
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|digits:4',
        ]);

        $users = User::where('subject_id', $subject->id)
            ->where('stage_id', $stage->id)
            ->where('grade_id', $grade->id)
            ->get();

        $students = [];
        foreach ($users as $user) {
            $payment = UserPayment::where('user_id', $user->id)
                ->where('subject_id', $subject->id)
                ->where('month', $request->month)
                ->where('year', $request->year)
                ->first();

            if (!$payment) {
                $students[] = $user;
            }
        }
        if (count($students) == 0) {
            return redirect()->back()->with('error', 'All users have paid for this subject');
        }

        $prices = Price::where('subject_id', $subject->id)->get()->keyBy('stage_id');
        $price = Price::where('subject_id', $subject->id)
            ->where('stage_id', $stage->id)
            ->firstOrFail();

        return view('payments.unpaid_users', compact('students', 'subject', 'stage', 'grade', 'price', 'request'));
    }
    public function selectSubject()
    {
        $subjects = Subject::all();
        return view('payments.select-subject', compact('subjects'));
    }

    public function selectStage(Subject $subject)
    {
        $stages = Stage::all();
        return view('payments.select-stage', compact('subject', 'stages'));
    }

    public function selectGrade(Subject $subject, Stage $stage)
    {
        return view('payments.select-grade', compact('subject', 'stage'));
    }

    public function showStudents(Subject $subject, Stage $stage, Grade $grade)
    {
        $students = $grade->students()
            ->where('subject_id', $subject->id)
            ->with(['payments' => function ($query) use ($subject) {
                $query->where('subject_id', $subject->id);
            }])
            ->get();

        $price = Price::where('subject_id', $subject->id)
            ->where('stage_id', $stage->id)
            ->first();

        return view('payments.select-student', compact('subject', 'stage', 'grade', 'students', 'price'));
    }

    public function createPayment(Subject $subject, Stage $stage, Grade $grade, User $student)
    {
        $price = Price::where('subject_id', $subject->id)
            ->where('stage_id', $stage->id)
            ->firstOrFail();

        $latestPayment = $student->payments()
            ->where('subject_id', $subject->id)
            ->latest()
            ->first();

        $suggestedMonth = $latestPayment ? $latestPayment->month % 12 + 1 : 1;
        $suggestedYear = $latestPayment ? ($latestPayment->month == 12 ? $latestPayment->year + 1 : $latestPayment->year) : date('Y');

        $oldPayments = $student->payments()
            ->where('subject_id', $subject->id)
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return view('payments.create', compact('subject', 'stage', 'grade', 'student', 'price', 'suggestedMonth', 'suggestedYear', 'oldPayments'));
    }

    public function storePayment(Request $request, Subject $subject, Stage $stage, Grade $grade, User $student)
    {
        $validated = $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'status' => 'required|boolean',
        ]);

        $PaymentFound = UserPayment::where('user_id', $student->id)
        ->where('subject_id', $subject->id)
        ->where('month', $validated['month'])
        ->where('year', $validated['year'])
        ->exists();

        $existingPayment = UserPayment::where('user_id', $student->id)
            ->where('subject_id', $subject->id)
            ->where('month', $validated['month'])
            ->where('year', $validated['year'])
            ->get();

        if ($PaymentFound) {
            $status = $existingPayment->first()->status;
            if ($status == 1) {
                return redirect()->back()
                    ->with('error', 'Payment already recorded for this student in the selected month/year')
                    ->withInput();
            } else {
                $existingPayment->first()->update([
                    'status' => $validated['status'],
                ]);
                return redirect()->route('payments.show-students', [$subject, $stage, $grade])
                    ->with('success', 'Payment updated successfully!');
            }
        } else {
            $price = Price::where('subject_id', $subject->id)
                ->where('stage_id', $stage->id)
                ->firstOrFail();

            UserPayment::create([
                'user_id' => $student->id,
                'subject_id' => $subject->id,
                'month' => $validated['month'],
                'year' => $validated['year'],
                'amount' => $price->price,
                'status' => $validated['status'],
            ]);

            return redirect()->route('payments.show-students', [$subject, $stage, $grade])
                ->with('success', 'Payment recorded successfully!');
        }
    }
}
