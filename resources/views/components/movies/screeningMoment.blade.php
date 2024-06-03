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
                        <td class="py-1 px-3 border-2 border-gray-400 dark:border-gray-500">Ainda por ver</td>
                        <td class="py-1 px-3 border-2 border-gray-400 dark:border-gray-500">
                            <button class="bg-blue-500 text-white py-1 px-3 rounded" onclick="selectScreening({{ $screening->id }})">
                                Select
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>