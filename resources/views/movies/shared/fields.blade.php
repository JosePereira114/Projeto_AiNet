@php
$mode = $mode ?? 'edit';
$readonly = $mode == 'show';
@endphp
<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="title" label="Title" width="md" :readonly="$readonly || ($mode == 'edit')" value="{{ old('title', $movie->title) }}" />
        <x-field.input name="genre" label="Genre" width="md" :readonly="$readonly || ($mode == 'edit')" value="{{ old('genre_code', $movie->genre_code) }}" />
        <x-field.input name="title" label="Title" width="md" :readonly="$readonly || ($mode == 'edit')" value="{{ old('title', $movie->fileName) }}" />
        <div class="flex space-x-4">
            <x-field.input name="year" label="Year" width="sm" :readonly="$readonly" value="{{ old('year', $movie->year) }}" />
        </div>
        <x-field.input name="Trailer" label="Trailer" :readonly="$readonly" value="{{ old('trailer', $movie->trailer_url) }}" />
        <x-field.text-area name="synopsis" label="Synopsis" :readonly="$readonly" value="{{ old('synopsis', $movie->synopsis) }}" />
    </div>
    <div class="pb-6">
    <x-field.image
            name="photo_file"
            label="Poster"
            width="md"
            :readonly="$readonly"
            deleteTitle="Delete Photo"
            :deleteAllow="($mode == 'edit') && ($movie->photo_filename)"
            deleteForm="form_to_delete_photo"
            :imageUrl="$movie->photoFullUrl"/>
    </div>
</div>