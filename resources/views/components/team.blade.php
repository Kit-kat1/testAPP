<div class="row">
    <div class="offset-3 col-md-6 align-center">
        <h2>{{ $name }}</h2>
        <h3>Total Rank: {{ $team[\App\Services\TeamService::RANK] }}</h3>
        <br>
        <table class="table text-center">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Player</th>
                <th scope="col">Rank</th>
            </tr>
            </thead>
            <tbody>
            @foreach($team[\App\Services\TeamService::PLAYERS] as $index => $player)
                <tr>
                    <th scope="row">{{ $index + 1 }}</th>
                    <td>{{ $player['first_name'] . ' ' . $player['last_name'] }}</td>
                    <td>{{ $player['ranking'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
