<?php

declare(strict_types=1);
namespace App\Services;

use App\Contracts\TeamInterface;

class TeamService
{
    /**
     * @var TeamInterface
     */
    protected $strategy;

    /**
     * Strategies definition
     *
     * @var array
     */
    protected $strategiesList = [
        FootballTeamStrategy::class
    ];

    /**
     * Strategies instances
     *
     * @var array
     */
    protected $strategies = [];

    /**
     * TeamService constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        foreach ($this->strategiesList as $strategyAlias) {
            $this->strategies[$strategyAlias] = app()->make($strategyAlias);
        }

        // Set first as default
        $this->setStrategy(reset($this->strategies));
    }

    public function setStrategy(TeamInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * @return array
     */
    public function generateTeams() : array
    {
        return $this->strategy->generateTeams();
    }
}
