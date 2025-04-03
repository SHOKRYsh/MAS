<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use App\Models\Stage;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $studentDistribution = User::select([
            'subjects.subject as subject_name',
            'stages.name as stage_name',
            'grades.name as grade_name',
            DB::raw('COUNT(users.id) as student_count'),
            DB::raw('COUNT(users.id) * prices.price as projected_revenue')
        ])
            ->leftJoin('subjects', 'users.subject_id', '=', 'subjects.id')
            ->leftJoin('stages', 'users.stage_id', '=', 'stages.id')
            ->leftJoin('grades', 'users.grade_id', '=', 'grades.id')
            ->leftJoin('prices', function ($join) {
                $join->on('prices.subject_id', '=', 'subjects.id')
                    ->on('prices.stage_id', '=', 'stages.id');
            })
            ->groupBy('subjects.subject', 'stages.name', 'grades.name', 'prices.price')
            ->orderBy('subjects.subject')
            ->orderBy('stages.name')
            ->orderBy('grades.name')
            ->get()
            ->groupBy('subject_name');
    
        // Calculate total projected revenue
        $totalProjectedRevenue = 0;
        foreach ($studentDistribution as $subject => $groups) {
            $totalProjectedRevenue += $groups->sum('projected_revenue');
        }
    
        // Get recent ratings
        $recentRatings = Rate::with(['user', 'subject'])
            ->latest()
            ->take(10)
            ->get();
    
        // Rating chart data
        $ratingChart = [
            'labels' => collect(range(6, 0))->map(function ($days) {
                return now()->subDays($days)->format('D');
            }),
            'data' => collect(range(6, 0))->map(function ($days) {
                return Rate::whereDate('created_at', now()->subDays($days))->count();
            }),
        ];
    
        // Rating distribution
        $ratingDistribution = [
            'labels' => ['5 Stars', '4 Stars', '3 Stars', '2 Stars', '1 Star'],
            'data' => [
                Rate::where('rate', 5)->count(),
                Rate::where('rate', 4)->count(),
                Rate::where('rate', 3)->count(),
                Rate::where('rate', 2)->count(),
                Rate::where('rate', 1)->count(),
            ],
            'colors' => ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b']
        ];
    
        // Get English students by stage
        $englishStages = Stage::withCount([
            'users' => function($query) {
                $query->whereHas('subjects', function($q) {
                    $q->where('subject', 'English');
                });
            }
        ])->get();
    
        // Get Technology students by stage
        $technologyStages = Stage::withCount([
            'users' => function($query) {
                $query->whereHas('subjects', function($q) {
                    $q->where('subject', 'Technology');
                });
            }
        ])->get();
    
        // Filter out empty stages
        $englishStages = $englishStages->filter(fn($stage) => $stage->users_count > 0);
        $technologyStages = $technologyStages->filter(fn($stage) => $stage->users_count > 0);
    
        $stageDistribution = [
            'english' => [
                'labels' => $englishStages->pluck('name'),
                'data' => $englishStages->pluck('users_count'),
                'colors' => ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b']
            ],
            'technology' => [
                'labels' => $technologyStages->pluck('name'),
                'data' => $technologyStages->pluck('users_count'),
                'colors' => ['#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#4e73df']
            ]
        ];
    
        return view('dashboard', [
            'totalStudents' => User::count(),
            'totalSubjects' => Subject::count(),
            'totalRatings' => Rate::count(),
            'unratedStudents' => User::doesntHave('rating')->count(),
            'totalProjectedRevenue' => $totalProjectedRevenue,
            'studentDistribution' => $studentDistribution,
            'recentRatings' => $recentRatings,
            'ratingChart' => $ratingChart,
            'ratingDistribution' => $ratingDistribution,
            'stageDistribution' => $stageDistribution,
            'englishStages' => $englishStages,
            'technologyStages' => $technologyStages
        ]);
    }
}
