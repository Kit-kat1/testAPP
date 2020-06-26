<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\FootballTeamStrategy;
use Tests\TestCase;

class PlayersIntegrityTest extends TestCase
{
    public function setUp() : void
    {
        parent::setUp();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGoaliePlayersExist()
    {
        /*
          Check there are players that have can_play_goalie set as 1
        */
        $result = User::where('user_type', 'player')->where('can_play_goalie', 1)->count();
        $this->assertTrue($result > 1);

    }

    public function testAtLeastOneGoaliePlayerPerTeam()
    {
        /*
                calculate how many teams can be made so that there is an even number of teams and they each have between 18-22 players.
                Then check that there are at least as many players who can play goalie as there are teams
        */

        $players = User::player()->orderBy('ranking', 'desc')->get();
        $goalies = $players->where('can_play_goalie', 1)->all();

        $footballTeamStrategy = new FootballTeamStrategy();

        $goaliesQty = count($goalies);
        $teamsQtyMax = $footballTeamStrategy->maxTeamsQty($players, $goaliesQty);
        $teamsQtyMin = $footballTeamStrategy->minTeamsQty($players, $goaliesQty);
        $teamsQtyAvg = $footballTeamStrategy->avgTeamsQty($teamsQtyMin, $teamsQtyMax);


        $this->assertGreaterThanOrEqual($teamsQtyAvg, count($goalies));
    }
}
