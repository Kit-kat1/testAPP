<?php

namespace App\Contracts;

interface TeamInterface
{
    const PLAYERS = 'players';
    const RANK = 'rank';

    public function generateTeams() : array ;
    public function assignPlayers(array $players, array &$teams) : void ;
    public function giveFakeNames(array $teams) : array ;

}
