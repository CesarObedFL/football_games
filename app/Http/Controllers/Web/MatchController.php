<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\MatchGame;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('matches.bets', [ 'matches' => MatchGame::all() ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        MatchGame::create([
            'localTeam' => $request->input('local_team'),
            'awayTeam' => $request->input('away_team'),
            'selectedTeam' => $request->input('selected_team'), //['local', 'visit']
            'schedule' => $request->input('schedule'), 
            'score' => $request->input('score'),
            'sofascore' => $request->input('sofascore'), //%
            'bettingClosed' => $request->input('betting_closed'), //['W', 'D', 'L']
            'foreBet' => $request->input('fore_bet'), //['W', 'D', 'L']
            'footballPredictions' => $request->input('football_predictions'), //['W', 'D', 'L']
        ]);

        return response()->json(['success' => 'Match created successfully...'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function show(MatchGame $match)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function edit(MatchGame $match)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MatchGame $match)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function destroy(MatchGame $match)
    {
        //
    }
}
