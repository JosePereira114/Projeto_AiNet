@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
    $movies = App\Models\Movie::all()->pluck('title', 'id')->toArray();
    $theaters = App\Models\Theater::all()->pluck('name', 'id')->toArray()
@endphp

<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.select name="movie_id" label="Movie" :readonly="$readonly" :options="$movies" value="{{ old('movie_id', $screening->movie_id) }}" />
        <x-field.select name="theater_id" label="Theater" :readonly="$readonly" :options="$theaters" value="{{ old('theater_id', $screening->theater_id) }}" />
        @if ($readonly)
            <x-field.input name="date" label="Date" :readonly="$readonly" :value="old('date', $screening->date)" />
        @else
            <x-field.date name="date" label="Date" :readonly="$readonly" value="{{ old('date', $screening->date) }}" />
        @endif
        @if ($readonly)
            <x-field.input name="start_time" label="Start_time" :readonly="$readonly" :value="old('start_time', $screening->start_time)" />
        @else
        <x-field.time name="start_time" label="Start_time" :readonly="$readonly" value="{{ old('start_time', $screening->start_time) }}"/>
        @endif
       
    </div>
    <div class="pb-6">
    </div>
</div>
