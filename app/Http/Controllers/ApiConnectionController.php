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
        /* Austria */ 'Red Bull Salzburg', 'Sturm Graz', 
        /* Azerbaidjan */ 'Qarabag',
        /* Belgium */ 'Club Brugge KV', 'Standard Liege', 'Anderlecht', 'Genk', 
        /* Belarus */ 'Bate Borisov', 'Dinamo Brest', 'Shakhter Soligorsk', 
        /* Bulgaria */ 'Ludogorets', 'Spartak Varna',
        /* China */ '',
        /* Croatia */ 'Dinamo Zagreb', 'NK Osijek', 'HNK Hajduk Split', 'HNK Rijeka',
        /* Czech-Republic */ 'Sparta Praha', 'Plzen',
        /* Denmark */ 'FC Copenhagen', 'FC Midtjylland',
        /* England */ 'Manchester City', 'Liverpool', 'Tottenham', 'Arsenal', 'Chelsea',
        /* Estonia */ 'Paide', 'Flora Tallinn', 'FC Levadia Tallinn', 
        /* Finland */ 'HJK helsinki',
        /* France */ 'Paris Saint Germain', 'Monaco', 'Lyon', 'Marseille', 'Lille',
        /* Germany */ 'Bayern Munich', 'Borussia Dortmund', 'Bayer Leverkusen', 
        /* Greece */ 'Panathinaikos', 'AEK Athens FC', 'PAOK', 'Olympiakos Piraeus',
        /* Hungary */ 'Ferencvarosi TC',
        /* Iceland */ 'Fram Reykjavik', 'Thor Akureyri', 'IR Reykjavik', 'KR Reykjavik', 'Breidablik', 
        /* Ireland */ 'Bohemians',
        /* Italy */ 'Juventus', 'AS Roma', 'Atalanta', 'Napoli', 'Inter', 'AC Milan',
        /* Japan */ 'V-varen Nagasaki', 'Nagoya Grampus', 'Yokohama F. Marinos', 'FC Ryukyu', 'Kawasaki Frontale', 'Albirex Niigata', 
        /* Kazakhstan */ 'FC Astana',
        /* Lithuania */ 'Kauno Žalgiris', 'Suduva Marijampole',
        /* Luxembourg */ 'Fola Esch',
        /* Moldova */ 'Sheriff Tiraspol',
        /* Netherlands */ 'Ajax', 'PSV Eindhoven', 'Feyenoord', 'AZ Alkmaar', 
        /* Norway */ 'Molde', 'Bodo/Glimt', 'Rosenborg', 
        /* Portugal */ 'Benfica', 'FC Porto', 'Sporting CP',
        /* Romania */ 'FCSB', 'CFR 1907 Cluj', 'Rapid',
        /* Russia */ 'CSKA Moscow', 'Dinamo Moscow', 'PFC Sochi', 'Spartak Moscow', 'Zenit Saint Petersburg', 
        /* Scotland */ 'Rangers', 'Celtic', 'Hibernian', 
        /* Serbia */ 'FK Crvena Zvezda', 'FK Partizan',
        /* Singapore */ 'Albirex Niigata S',
        /* Slovakia */ 'Spartak Trnava', 'Slovan Bratislava', 'Žilina',
        /* Slovenia */ 'Maribor',
        /* South-Korea */ 'Jeonbuk Motors', 'Ulsan Hyundai FC', 
        /* Spain */ 'Real Madrid', 'Sevilla', 'Barcelona', 'Real Betis', 'Villarreal', 'Atletico Madrid',
        /* Sweden */ 'Malmo FF', 
        /* Switzerland */ 'FC Basel 1893', 'BSC Young Boys', 
        /* Turkey */ 'Fenerbahce', 'Galatasaray',
        /* Ukraine */ 'Dynamo Kyiv', 'Shakhtar Donetsk', 
        /* Wales */ 'The New Saints',
        /* */
    );

    public function matches_by_date($date)
    {
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
                                                'season' => $match_one->league->season,
                                                'round' => $match_one->league->round,
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
