@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="title" label="Title" width="md"
                        :readonly="$readonly || ($mode == 'edit')"
                        value="{{ old('title', $movie->title) }}"/>
        <x-field.radio-group name="genre" label="Genre of movie" :readonly="$readonly"
                        value="{{ old('genre', $movie->genre) }}"
                        :options="[
                            
                        ]"/>
        <div class="flex space-x-4">
            <x-field.input name="year" label="Year" width="sm"
                            :readonly="$readonly"
                            value="{{ old('year', $movie->year) }}"/>
        </div>
        <x-field.input name="Trailer" label="Trailer" :readonly="$readonly"
                            value="{{ old('trailer', $movie->trailer_url) }}"/>
        <x-field.text-area name="synopsis" label="Synopsis" :readonly="$readonly"
                            value="{{ old('synopsis', $movie->synopsis) }}"/>
    </div>
    <div class="pb-6">
        
    </div>
</div>
