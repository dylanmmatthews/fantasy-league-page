@foreach ($stats as $stat)
    <div class="relative overflow-x-auto">
        <table class="text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Player name</th>
                    @foreach ($stat->getPositionalStats($devyPlayer->position) as $key => $statOutput)
                        <th scope="col" class="px-6 py-3">{{ $key }}</td>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">{{$devyPlayer->name}}</td>
                    @foreach ($stat->getPositionalStats($devyPlayer->position) as $key => $statOutput)
                        <td class="px-6 py-4">{{ $statOutput }}</td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
    <hr />
@endforeach
