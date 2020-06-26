<?php

namespace App\Services;

use App\Contracts\TeamInterface;
use App\Models\User;
use Faker\Factory;

class FootballTeamStrategy implements TeamInterface
{
    public function generateTeams(): array
    {
        $players = User::where('user_type', 'player')->orderBy('ranking', 'desc')->get();
        $goalies = $players->where('can_play_goalie', 1)->all();

        $teamsQtyMax = min(floor($players->count() / 18), count($goalies));
        $teamsQtyMin = min(floor($players->count() / 22), count($goalies));

        $teamsQtyAvg = floor(($teamsQtyMin + $teamsQtyMax) / 2);

        if ($teamsQtyAvg % 2 !== 0) {
            $teamsQtyAvg++;
        }

        $teams = [];

        for ($i = 0; $i < $teamsQtyAvg; $i++) {
            $teams[$i] = [
                'players' => [],
                'rank' => 0
            ];
        }

        $this->assignPlayers($goalies, $teams);
        $this->assignPlayers($players->where('can_play_goalie', 0)->all(), $teams);

        return $this->giveFakeNames($teams);
    }

    public function assignPlayers(array $players, &$teams): void
    {
        $index = 0;

        foreach ($players as $key => $player) {
            $teams[$index][TeamService::PLAYERS][] = $player;
            $teams[$index][TeamService::RANK] += $player->ranking;

            $index++;

            if ($index === count($teams)) {
                $index = 0;
            }
        }
    }

    /**
     * @param array $teams
     * @return array
     */
    public function giveFakeNames(array $teams) : array
    {
        $faker = Factory::create();
        $namedTeams = [];

        foreach ($teams as $key => $team) {
            $namedTeams[$faker->name] = $team;
        }

        return $namedTeams;
    }
}
