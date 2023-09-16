<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $team->team_display_name }}</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>

<body class="bg-white border-gray-200 px-2 sm:px-4 py-2.5 rounded dark:bg-gray-900 dark:text-white">
    <livewire:navigation />
    {{-- <form id="logout-form" action="{{ route('generate', ) }}" method="POST">
        @csrf
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Button
          </button>
    </form> --}}
    <h1 class="mb-2 mt-0 text-5xl font-medium leading-tight text-primary dark:text-gray-400">
        {{ $team->team_display_name }}
    </h1>
    @foreach ($devyPlayers as $devyPlayer)
        <livewire:weekly-stats :stats="$devyPlayer->weeklyDevyStats()->where('week', $week)->get()" :devyPlayer="$devyPlayer" />
    @endforeach
    @livewireScripts
</body>

</html>
