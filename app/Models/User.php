<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Models
 */
class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_type', 'first_name', 'last_name', 'ranking', 'can_play_goalie'
    ];

    public function scopeGoalie($query)
    {
        return $query->where('can_play_goalie', 1);
    }

    public function scopePlayer($query)
    {
        return $query->where('user_type', 'player');
    }
}
