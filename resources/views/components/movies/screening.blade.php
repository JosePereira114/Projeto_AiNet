

<h2 class="text-2xl font-bold mt-6 mb-4">History Screenings</h2>
        <div>
            <table class="table-auto border-collapse w-full">
                <thead>
                    <tr>
                        <th class="border-2 border-gray-400 dark:border-gray-500 py-1 px-3 bg-gray-100 dark:bg-gray-800">theater</th>
                        <th class="py-1 px-3 border-2 border-gray-400 dark:border-gray-500 bg-gray-100 dark:bg-gray-800">Date</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($screenings as $screening)
                        <tr>
                            <td class="py-1 px-3 border-2 border-gray-400 dark:border-gray-500">{{ $screening->theater_id }}</td>
                            <td class="py-1 px-3 border-2 border-gray-400 dark:border-gray-500">{{ $screening->date }}</td>
                        </tr>
                @endforeach
                </tbody>
            </table>
