@php
$mode = $mode ?? 'edit';
$readonly = $mode == 'show';
@endphp
<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="id" label="Id" width="md" :readonly="$readonly || ($mode == 'edit')" value="{{ old('id', $ticket->id) }}" />
        <x-field.input name="price" label="Price" width="md" :readonly="$readonly || ($mode == 'edit')" value="{{ old('price', $ticket->price) }}" />
        <x-field.input name="status" label="Status" width="md" :readonly="$readonly || ($mode == 'edit')" value="{{ old('status', $ticket->status) }}" />
    </div>
    <div class="pb-6">

    </div>
</div>