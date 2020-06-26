<?php

namespace App\Contracts;

interface TeamInterface
{
    public function generateTeams() : array ;
    public function assignPlayers(array $players, array &$teams) : void ;
    public function giveFakeNames(array $teams) : array ;

}
