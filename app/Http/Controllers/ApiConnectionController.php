<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiConnectionController extends Controller
{
    protected static $HEADERS = array(
        'x-rapidapi-key: f9d7844a8119e855a8b24d8ee8cff213',
        'x-rapidapi-host: v3.football.api-sports.io'
    );

    protected static $TIMEOUT = 0;

    public static function connection($endpoint)
    {
        $curl = curl_init();   
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://v3.football.api-sports.io/'.$endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => self::$TIMEOUT,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => self::$HEADERS,
        ));
        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $response = 'Error:' . curl_error($curl);
        }
        curl_close($curl);
        return $response;
    }

    public function matchesByDate($date)
    {
        $data = self::connection('fixtures?date='.$date.'&status=NS&timezone=America/Mexico_City');
        $matchesByLeague = array();
        $teams = array();

        $data = json_decode($data);
        foreach($data->response as $match_one) {
            foreach($data->response as $match_two) {
                if ($match_one->league->name === $match_two->league->name) {
                    if ($match_one->league->country === $match_two->league->country) {
                        array_push($teams, array(
                                'date' => $match_two->fixture->date,
                                'status' => $match_two->fixture->status,
                                'teams'=> $match_two->teams,
                                'score' => $match_two->score
                            )
                        );
                    }
                }

            }
            $matches = array(
                'league' => $match_one->league->name,
                'league_logo' => $match_one->league->logo,
                'country' => $match_one->league->country,
                'country_flag' => $match_one->league->flag,
                'total_matches' => count($teams),
                'matches' => $teams
            );
            $teams = array();
            array_push($matchesByLeague, $matches);
        }

        // removing duplicate objects 
        $matchesByLeague = array_map("unserialize", array_unique(array_map("serialize", $matchesByLeague)));
        
        // sorting by country
        usort($matchesByLeague, function ($a, $b) {
            if ($a['country'] == $b['country']) {
                return 0;
            }
            return ($a['country'] < $b['country']) ? -1 : 1;
        });

        return json_encode(array(
                    'total' => count($matchesByLeague),
                    'matchesByLeague' => $matchesByLeague
                )
        );
    }
    
}
