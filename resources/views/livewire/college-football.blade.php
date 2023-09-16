@foreach ($teamPlayers as $teamName => $devy)
    <h1 class="mb-2 mt-0 text-5xl font-medium leading-tight text-primary dark:bg-gray-700 dark:text-gray-400">
        {{ $teamName }}
    </h1>

    @foreach ($devy as $name => $player)
        <div class="relative overflow-x-auto">
            <table class="text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Player name</th>
                        @foreach ($player as $category => $specificCategories)
                            @foreach ($specificCategories as $keyCategory => $stats)
                                <th scope="col" class="px-6 py-3">{{ $category }} - {{ $keyCategory }}</td>
                            @endforeach
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $name }}</th>
                        @foreach ($player as $category => $specificCategories)
                            @foreach ($specificCategories as $keyCategory => $stats)
                                <td class="px-6 py-4">{{ $stats }}</td>
                            @endforeach
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
        <hr />
    @endforeach
@endforeach
