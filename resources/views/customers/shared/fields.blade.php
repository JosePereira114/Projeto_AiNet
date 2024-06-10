@php
$mode = $mode ?? 'edit';
$readonly = $mode == 'show';
$imageUrl = $customer->user->photo_filename ?? '';
@endphp
<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="id" label="Id" width="md" :readonly="$readonly || ($mode == 'edit')" value="{{ old('id', $customer->id) }}" style="{{ $mode == 'edit' ? '' : 'display: none;' }}" />
        <x-field.input name="name" label="Name" :readonly="$readonly" value="{{ old('name', optional($customer->user)->name) }}" />
        <x-field.input name="email" label="Email" :readonly="$readonly" value="{{ old('email', optional($customer->user)->email) }}" />
        <x-field.input name="nif" label="NIF" :readonly="$readonly" value="{{ old('nif', $customer->nif) }}" />
        <x-field.select name="payment_type" label="Payment_type" :readonly="$readonly" :options="['VISA' => 'VISA', 'PAYPAL' => 'PAYPAL', 'MBWAY' => 'MBWAY']" value="{{ old('payment_type', $customer->payment_type) }}" />
    </div>
    <div class="pb-6">
        <x-field.image name="photo_file" label="Photo" width="md" :readonly="$readonly" deleteTitle="Delete Photo" :deleteAllow="($mode == 'edit') && (optional($customer->user)->photo_filename)" deleteForm="form_to_delete_photo" :imageUrl="$imageUrl" />
    </div>
</div>