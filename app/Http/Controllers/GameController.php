<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Image;
use App\Game;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limit = 2;
        $images = Image::inRandomOrder()->limit($limit)->get();
        if($images->count()){
            return view('pages.game')->withImages($images);
        }
        return redirect('/images');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $winner = Image::where('id', '=' , $request->winner)->first();
        $loser = Image::where('id', '=' , $request->loser)->first();

        // For winner
        $wins = $winner->wins + 1;

        $winner_expected_score = Game::expected($loser->score, $winner->score);
        $winner_new_score = Game::win($winner->score, $winner_expected_score);

        $winner_rank = Game::rank($winner_new_score, $wins, $winner->wins);

        $winner->update([
            'score' => $winner_new_score,
            'wins' => $wins,
            'rank' => $winner_rank
            ]);

        // For loser
        $losses = $loser->losses + 1;  

        $loser_expected_score = Game::expected($winner->score, $loser->score);
        $loser_new_score = Game::loss($loser->score, $loser_expected_score);

        $loser_rank = Game::rank($loser_new_score, $losses, $loser->wins);

        $loser->update([
            'score' => $loser_new_score,
            'losses' => $losses,
            'rank' => $loser_rank
            ]);      

            Game::create([
                'winner' => $request->winner,
                'loser' => $request->loser
                ]);  

            return redirect()->back()->with('success', 'Scores updated continue playing' );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
