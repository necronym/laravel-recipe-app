<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Recipe;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // Admin index view
    public function index()
    {
        if (auth()->user()->RoleID !== 1) {
            abort(403);
        }

        // Only get non-dismissed reports
        $reports = Report::where('Dismissed', false)->get()->groupBy('TargetType');

        $recipeReports = ($reports['recipe'] ?? collect())->map(function ($report) {
            $report->recipe = Recipe::find($report->TargetID);
            return $report;
        });

        $commentReports = ($reports['comment'] ?? collect())->map(function ($report) {
            $report->comment = Comment::with('recipe')->find($report->TargetID);
            return $report;
        });

        $userReports = ($reports['user'] ?? collect())->map(function ($report) {
            $report->user = User::find($report->TargetID);
            return $report;
        });

        return view('admin.reports.index', compact('recipeReports', 'commentReports', 'userReports'));
    }

    // Report submission
    public function store(Request $request)
    {
        $validated = $request->validate([
            'TargetType' => 'required|in:user,recipe,comment',
            'TargetID' => 'required|integer',
            'Reason' => 'nullable|string|max:1000',
        ]);

        Report::create([
            'ReporterID' => Auth::id(),
            'TargetType' => $validated['TargetType'],
            'TargetID' => $validated['TargetID'],
            'Reason' => $validated['Reason'],
        ]);

        return back()->with('success', 'Report submitted.');
    }

    // Dismiss a report
    public function dismiss($id)
    {
        $report = Report::findOrFail($id);
        if (auth()->user()->RoleID !== 1) {
            abort(403);
        }

        $report->Dismissed = true;
        $report->save();

        return back()->with('success', 'Report dismissed.');
    }
}

