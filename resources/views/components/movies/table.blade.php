<div {{ $attributes }} class="flex justify-center">
    <table class="table-auto border-collapse mx-auto">
        <thead>
            <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
                <th class="px-2 py-2 text-left">Poster</th>
                <th class="px-2 py-2 text-left">Name</th>
                <th class="px-2 py-2 text-left">Genre</th>
                <th class="px-2 py-2 text-left">Year</th>
                @if($showView)
                    <th></th>
                @endif
                @if($showEdit)
                    <th></th>
                @endif
                @if($showDelete)
                    <th></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($movies as $movie)
                <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                    <td class="px-2 py-2 text-left">
                        <img src="{{$movie->getImageUrlAttribute() }}" alt="Movie Poster" width="75">
                    </td>
                    <td class="px-2 py-2 text-left">{{ $movie->title }}</td>
                    <td class="px-2 py-2 text-left">{{ $movie->genre_code }}</td>
                    <td class="px-2 py-2 text-left">{{ $movie->year }}</td>
                    @if($showView)
                        <td class="text-center">
                            <x-table.icon-show class="ps-3 px-0.5" href="{{ route('movies.show', ['movie' => $movie]) }}" />
                        </td>
                    @endif
                    @if($showEdit)
                        @can('update', App\Models\Movie::class)
                            <td class="text-center">
                                <x-table.icon-edit class="px-0.5" href="{{ route('movies.edit', ['movie' => $movie]) }}" />
                            </td>
                        @endcan
                    @endif
                    @if($showDelete)
                        @can('delete', App\Models\Movie::class)
                            <td class="text-center">
                                <x-table.icon-delete class="px-0.5" action="{{ route('movies.destroy', ['movie' => $movie]) }}" />
                            </td>
                        @endcan
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
