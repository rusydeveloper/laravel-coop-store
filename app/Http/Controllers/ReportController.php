<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;

        $report = Report::where('user_id', $user_id)->first();

        return view('reports.index', compact('report'));
    }


    public function create()
    {
        return view('reports.create');
    }


    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        $report = new Report;
        $report->user_id = $user_id;
        $report->save();

        return redirect()->route('report')->with('sucess', 'Report berhasil dibuat.');
    }


    public function show(Report $report)
    {
        $user_id = Auth::user()->id;
        $report = Report::where('user_id', $user_id)->first();

        return view('reports.show', compact('report'));
    }

    public function edit(Report $report)
    {
        $user_id = Auth::user()->id;
        $report = Report::where('user_id', $user_id)->first();
         return view('reports.edit', compact('report'));
    }


    public function update(Request $request, Report $report)
    {
        $user_id = Auth::user()->id;
        $report_id = $request->report_id;

        $report = Report::where('id', $report_id)->first();
        
        $report->name = $request->name;
        $report->save();

        return redirect()->route('report')->with('sucess', 'Report berhasil diedit.');
    }

    public function destroy(Report $report)
    {
        Report::destroy($request->report_id);

        return redirect()->route('report')->with('danger', 'Report berhasil didelete.');
    }
}
