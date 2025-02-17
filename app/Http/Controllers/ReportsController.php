<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function teamCaptures(int $id)
    {
        $team = \App\Models\Team::with('players')->find($id);
        return view('report-captures', [
            'team' => $team,
            'captures' => $team->stats($id),
        ]);
    }

    public function Ranking()
    { 
        $teams = \App\Models\Team::all();
        $ranking=[];
        // order by amount of points
        foreach( $teams as $team ){
            $ranking[$team->id] = [
                'name' =>$team->name,
                'points' => $team->stats($team->id)['total_points'],
            ];
        }
        // sort by points
        usort($ranking, function($a, $b) {
            return $b['points'] - $a['points'];
            });
        // take 10 first
        $ranking = array_slice($ranking, 0, 10);

        return view('report-ranking', [
            'ranking' => $ranking,
        ]);
    }
}
