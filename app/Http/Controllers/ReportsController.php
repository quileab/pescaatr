<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function reportTeamsFish()
    {
        $species = \App\Models\Species::all();
        $teams = \App\Models\Team::orderBy('number')->get(); //take(5)->get();
        return view(
            'reportTeamsCaptures',
            compact('teams', 'species')
        );
    }

    public function reportTeamsHP()
    {
        $teams = \App\Models\Team::orderBy('hp')->get(); //take(5)->get();
        return view(
            'reportTeamsHP',
            compact('teams')
        );
    }

    public function reportTeamsDebts()
    {
        $teams = \App\Models\Team::select(['teams.id', 'teams.number', 'teams.name'])
            ->selectRaw('SUM(payments.amount) as total_debt')
            ->leftJoin('payments', 'teams.id', '=', 'payments.team_id')
            ->groupBy('teams.id', 'teams.number', 'teams.name')
            ->orderBy('total_debt', 'asc')
            ->get();
        //->take(5)->get()->toArray();
        return view(
            'reportTeamsDebts',
            compact('teams')
        );
    }
}
