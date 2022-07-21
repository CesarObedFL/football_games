<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

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

    /**
     * get the matches from APIs by date
     * 
     * @param Date the matches date
     */
    public function matches_by_date($date)
    {
        $response = Http::withHeaders(self::$HEADERS)->get('https://v3.football.api-sports.io/fixtures?date='.$date.'&timezone=America/Mexico_City');
        $data = json_decode($response);

        $matches_by_league = array();
        $matches = array();
        $is_bet_oportunity = false; // if a saved team is home it's == true
        $is_team_saved = false;  // if one of the match team  is in the saved teams array it´s == true

        // stored in the array the matches by league and country
        foreach($data->response as $match_one) {
            foreach($data->response as $match_two) {
                if ($match_one->league->name === $match_two->league->name) {
                    if ($match_one->league->country === $match_two->league->country) {
                        if( in_array( $match_two->teams->home->name, self::$SAVED_TEAMS ) ) {
                            $is_bet_oportunity = true;
                        }

                        if( in_array( $match_two->teams->home->name, self::$SAVED_TEAMS ) || in_array( $match_two->teams->home->name, self::$SAVED_TEAMS )) {
                            $is_team_saved = true;
                        }

                        array_push($matches, array(
                                'date' => $match_two->fixture->date,
                                'status' => $match_two->fixture->status,
                                'teams'=> $match_two->teams,
                                'score' => $match_two->score,
                                'is_bet_oportunity' => $is_bet_oportunity,
                                'is_team_saved' => $is_team_saved
                            )
                        );
                    } // endif ($match_one->league->country === $match_two->league->country)
                    $is_bet_oportunity = false;
                    $is_team_saved = false;
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

    /**
     * web scraping from bettingclosed.com scores by date
     */
    public function bt_scraping() 
    {
        $client = new Client(HttpClient::create(['timeout' => 60])); // create the scraping request

        $predictions = array();

        $crawler = $client->request('GET', 'https://www.bettingclosed.com/predictions/date-matches/2022-07-22/bet-type/correct-scores');

        // extracting the matches table
        $matches_table = $crawler->filter('[class="tbmatches table"]')->filter('tr')->each(function($tr, $i) use (&$predictions) {
            $match_td = $tr->filter('td')->each(function($td, $i) {

                $match_date = $td->filter('[class="dataMt"]')->each(function($class, $i) {
                    return $class->text();
                });
                $team_home = $td->filter('[class="teamAmatch hidden-phone hidden-tablet"]')->each(function($class, $i) {
                    return $class->text();
                });
                $team_away = $td->filter('[class="teamBmatch hidden-phone hidden-tablet"]')->each(function($class, $i) {
                    return $class->text();
                });
                $score_prediction = $td->filter('[class="predMt"]')->each(function($class, $i) {
                    return $class->text();
                });

                // return table data founded
                return [ 'home' => $team_home, 'score_prediction' => $score_prediction, 'away' => $team_away, 'match_date' => $match_date ];
            });
            
            // extracting the empty data and pushing to the predictions array only the got data
            if(count($match_td) > 0) { 
                $team_home = ''; $team_away = ''; $score_prediction = ''; $match_date = '';
                foreach( $match_td as $key => $_match ) {
                    if (count($_match['match_date']) > 0) {
                        $match_date = $_match['match_date'][0] ?? '-';
                    }
                    if (count($_match['home']) > 0) {
                        $team_home = $_match['home'][0] ?? '-';
                    }
                    if (count($_match['score_prediction']) > 0) {
                        $score_prediction = $_match['score_prediction'][0] ?? '-';
                    }
                    if (count($_match['away']) > 0) {
                        $team_away = $_match['away'][0] ?? '-';
                    }
                }

                if ( !empty($team_home) && !empty($score_prediction) && !empty($team_away) ) {
                    array_push($predictions, [ 'home' => $team_home, 'score_prediction' => $score_prediction, 'away' => $team_away, 'date' => $match_date ]); 
                }
            }

            return $match_td;

        });


        dd($predictions);

    }
    
}
