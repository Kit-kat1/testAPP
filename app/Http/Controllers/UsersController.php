<?php

namespace App\Http\Controllers;

use App\Services\TeamService;

class UsersController
{
    public function index(TeamService $teamService)
    {
        $teams = $teamService->generateTeams();

        return view('users', [
            'teams' => $teams
        ]);
    }
}
