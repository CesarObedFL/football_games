<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiConnectionController extends Controller
{
    protected static $HEADERS = array(
        'x-rapidapi-key' => 'f9d7844a8119e855a8b24d8ee8cff213',
        'x-rapidapi-host' => 'v3.football.api-sports.io'
    );

    protected static $TIMEOUT = 0;

    protected static $SAVED_TEAMS = array(
        'Club Brugge KV', // Belgium
        'Real Madrid', 'Sevilla' // Spain
    );

    public function matches_by_date($date)
    {
        //$response = Http::withHeaders(self::$HEADERS)->get('https://v3.football.api-sports.io/fixtures?date='.$date.'&status=NS&timezone=America/Mexico_City');
        $response = Http::withHeaders(self::$HEADERS)->get('https://v3.football.api-sports.io/fixtures?date='.$date.'&timezone=America/Mexico_City');
        $data = json_decode($response);

        $matches_by_league = array();
        $matches = array();
        $bet_oportunity = false; // if a saved team is home it's == true

        // stored in the array the matches by league and country
        foreach($data->response as $match_one) {
            foreach($data->response as $match_two) {
                if ($match_one->league->name === $match_two->league->name) {
                    if ($match_one->league->country === $match_two->league->country) {
                        if( in_array( $match_two->teams->home->name, self::$SAVED_TEAMS ) ) {
                            $bet_oportunity = true;
                        }

                        array_push($matches, array(
                                'date' => $match_two->fixture->date,
                                'status' => $match_two->fixture->status,
                                'teams'=> $match_two->teams,
                                'score' => $match_two->score,
                                'bet_oportunity' => $bet_oportunity
                            )
                        );
                    } // endif ($match_one->league->country === $match_two->league->country)
                    $bet_oportunity = false;
                } // endif ($match_one->league->name === $match_two->league->name)

            } // endforeach($data->response as $match_two)

            // matches by league array
            array_push($matches_by_league, array(
                                                'league' => $match_one->league->name,
                                                'league_logo' => $match_one->league->logo,
                                                'country' => $match_one->league->country,
                                                'country_flag' => $match_one->league->flag,
                                                'total_matches' => count($matches),
                                                'matches' => $matches
                                            ));
            $matches = array(); // reinitializing matches array...

        } // endforeach($data->response as $match_one)

        // removing duplicate objects 
        $matches_by_league = array_map("unserialize", array_unique(array_map("serialize", $matches_by_league)));
        
        // sorting by country
        usort($matches_by_league, function ($match_a, $match_b) {
                                    if ($match_a['country'] == $match_b['country']) {
                                        return 0;
                                    }
                                    return ($match_a['country'] < $match_b['country']) ? -1 : 1;
                                });

        return json_encode([
                    'total' => count($matches_by_league),
                    'matches_by_league' => $matches_by_league
                ]);
    }

    public function get_countries()
    {
        $response = Http::withHeaders(self::$_HEADERS)->get('https://v3.football.api-sports.io/countries');
        $data = json_decode($response);
        dd($data);
    }
    
}
