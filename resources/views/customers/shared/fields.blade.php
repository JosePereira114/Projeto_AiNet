@php
$mode = $mode ?? 'edit';
$readonly = $mode == 'show';
@endphp
<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">

        <x-field.input name="id" label="Id" width="md" :readonly="$readonly || ($mode == 'edit')" value="{{ old('code', $customer->id) }}" style="{{ $mode == 'edit' ? '' : 'display: none;' }}" />
        <x-field.input name="name" label="Name" :readonly="$readonly" value="{{ old('name', $customer->name) }}" />
        <x-field.input name="email" label="Email" :readonly="$readonly" value="{{ old('email', $customer->email) }}" />
        <x-field.input name="type" label="Type" :readonly="$readonly" value="{{ old('type', $customer->type) }}" />
    </div>
    <div class="pb-6">
        <x-field.image name="photo_file" label="Photo" width="md" :readonly="$readonly" deleteTitle="Delete Photo" :deleteAllow="($mode == 'edit') && ($customer->photo_filename)" deleteForm="form_to_delete_photo" :imageUrl="$customer->photoFullUrl" />
    </div>
</div>