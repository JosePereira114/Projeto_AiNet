@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp

<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
    <x-field.input name="name" label="Name" :readonly="$readonly"
    value="{{ old('name', $theater->name) }}"/>
    <x-field.input name="num_seats" label="Num_seats" :readonly="$readonly"
                        value="{{ old('num_seat', $theater->seats()->count()) }}"/>
    </div>
    <div class="pb-6">
        <x-field.image
            name="photo_file"
            label="Photo"
            width="md"
            :readonly="$readonly"
            deleteTitle="Delete Photo"
            :deleteAllow="($mode == 'edit') && ($theater->photo_filename)"
            deleteForm="form_to_delete_photo"
            :imageUrl="$theater->photoFullUrl"/>
    </div>
</div>
