@extends('layouts.main')
@section('title', 'SportsRecruits')
@section('content')
    @foreach($teams as $teamName => $team)
        @component('components.team', ['team' => $team, 'name' => $teamName])
        @endcomponent
    @endforeach
@endsection
