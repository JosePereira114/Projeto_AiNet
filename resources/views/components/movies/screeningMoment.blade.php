<div class="screening-list">
   
    <div>
        <table class="table-auto border-collapse w-full">
            <thead>
                <tr>
                    <th class="border-2 border-gray-400 dark:border-gray-500 py-1 px-3 bg-gray-100 dark:bg-gray-800">Theater</th>
                    <th class="py-1 px-3 border-2 border-gray-400 dark:border-gray-500 bg-gray-100 dark:bg-gray-800">Date(Hour)</th>
                    <th class="py-1 px-3 border-2 border-gray-400 dark:border-gray-500 bg-gray-100 dark:bg-gray-800">Lugares Livres</th>
                    <th class="py-1 px-3 border-2 border-gray-400 dark:border-gray-500 bg-gray-100 dark:bg-gray-800">Selecionar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($screenings as $screening)
                    <tr>
                        <td class="py-1 px-3 border-2 border-gray-400 dark:border-gray-500">{{ $screening->theater->name }}</td>
                        <td class="py-1 px-3 border-2 border-gray-400 dark:border-gray-500">{{ $screening->date }}({{$screening->start_time}})</td>
                        <td class="py-1 px-3 border-2 border-gray-400 dark:border-gray-500">{{$screening->theater->seats->count() - $screening->tickets->count()}}</td>
                        <td class="py-1 px-3 border-2 border-gray-400 dark:border-gray-500">
                        <a class="h-48 w-48 md:h-72 md:w-72 md:min-w-72 md:max-w-72 mx-auto md:m-0"href="{{ route('tickets.buy', ['screening' => $screening]) }}" >
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Select Screening</button>
                        </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>