<div>
    <figure class="h-auto md:h-72 flex flex-col md:flex-row
                    rounded-none sm:rounded-xl
                    bg-white dark:bg-gray-900
                    my-4 p-8 md:p-0">
        <a class="h-48 w-48 md:h-72 md:w-72 md:min-w-72 md:max-w-72 mx-auto md:m-0" href="{{ route('movies.show', ['movie' => $movie]) }}">
            <img class="h-full aspect-auto mx-auto rounded-full md:rounded-l-xl md:rounded-r-none"
            src="{{ $movie->getImageUrlAttribute() }}">
        </a>
        <div class="h-auto p-6 text-center md:text-left space-y-1 flex flex-col">
            <a class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight" href="{{ route('movies.show', ['movie' => $movie]) }}">
                {{ $movie->title }}
            </a>
            <figcaption class="font-medium">
                <address class="font-light text-gray-700 dark:text-gray-300">
                    <a href="{{ $movie->trailer_url }}"target="_blank">{{ $movie->trailer_url }}</a>.
                </address>
            </figcaption>
            <p class="pt-4 font-light text-gray-700 dark:text-gray-300 overflow-y-auto">
                {{ $movie->synopsis }}
            </p>
            <a class="h-48 w-48 md:h-72 md:w-72 md:min-w-72 md:max-w-72 mx-auto md:m-0"href="{{ route('movies.showMomentScreenings', ['movie' => $movie]) }}" >
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Comprar Bilhete</button>
            </a>
        </div>
    </figure>
</div>
