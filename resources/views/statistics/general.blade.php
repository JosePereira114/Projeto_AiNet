@extends('layouts.main')

@section('header-title', 'Estatísticas')

@section('main')


<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <div class="bg-blue-200 text-blue-800 px-4 py-2 rounded-lg shadow-md mr-4">
                <span class="font-semibold">Total Tickets Sold: {{ $totalTickets }}</span>
            </div>
            <div class="bg-blue-200 text-blue-800 px-4 py-2 shadow-md mr-4">
                <span class="font-semibold">Total Screenings: {{ $totalScreenings }}</span>
            </div>
        <div class="mt-6 flex justify-center">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Género
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Número de Filmes
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($genres_countmovies as $genre)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $genre->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $genre->movies_count }}</div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>




        </div>
    </div>
</body>



@endsection