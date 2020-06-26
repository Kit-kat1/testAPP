<?php

declare(strict_types=1);
namespace App\Services;

use App\Contracts\TeamInterface;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Eloquent\Collection;

class FootballTeamStrategy implements TeamInterface
{
    const MIN_PLAYERS_QTY = 18;
    const MAX_PLAYERS_QTY = 22;

    public function generateTeams(): array
    {
        $players = User::player()->orderBy('ranking', 'desc')->get();
        $goalies = $players->where('can_play_goalie', 1)->all();

        $goaliesQty = count($goalies);
        $teamsQtyMax = $this->maxTeamsQty($players, $goaliesQty);
        $teamsQtyMin = $this->minTeamsQty($players, $goaliesQty);
        $teamsQtyAvg = $this->avgTeamsQty($teamsQtyMin, $teamsQtyMax);

        $teams = $this->createTeams($teamsQtyAvg);

        $this->assignPlayers($goalies, $teams);
        $this->assignPlayers($players->where('can_play_goalie', 0)->all(), $teams);

        return $this->giveFakeNames($teams);
    }

    public function assignPlayers(array $players, array &$teams): void
    {
        $index = 0;

        foreach ($players as $key => $player) {
            $teams[$index][TeamInterface::PLAYERS][] = $player;
            $teams[$index][TeamInterface::RANK] += $player->ranking;

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

    /**
     * @param Collection $players
     * @param int $goaliesQty
     * @return int
     */
    public function minTeamsQty(Collection $players, int $goaliesQty) : int
    {
        return intval(min(floor($players->count() / self::MAX_PLAYERS_QTY), $goaliesQty));
    }

    /**
     * @param Collection $players
     * @param int $goaliesQty
     * @return int
     */
    public function maxTeamsQty(Collection $players, int $goaliesQty) : int
    {
        return intval(min(floor($players->count() / self::MIN_PLAYERS_QTY), $goaliesQty));
    }

    /**
     * @param int $teamsQtyMin
     * @param int $teamsQtyMax
     * @return int
     */
    public function avgTeamsQty(int $teamsQtyMin, int $teamsQtyMax) : int
    {
        $teamsQtyAvg = round(($teamsQtyMin + $teamsQtyMax) / 2, PHP_ROUND_HALF_EVEN);

        if ($teamsQtyAvg % 2 !== 0) {
            $teamsQtyAvg++;
        }

        return intval($teamsQtyAvg);
    }

    /**
     * @param $teamsQtyAvg
     * @return array
     */
    public function createTeams($teamsQtyAvg) : array
    {
        $teams = [];

        for ($index = 0; $index < $teamsQtyAvg; $index++) {
            $teams[$index] = [
                TeamInterface::PLAYERS => [],
                TeamInterface::RANK => 0
            ];
        }

        return $teams;
    }
}
