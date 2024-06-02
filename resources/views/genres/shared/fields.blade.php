@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="code" label="Code" width="md"
                        :readonly="$readonly || ($mode == 'edit')"/>
        <x-field.input name="name" label="Name" :readonly="$readonly"/>
    </div> 
</div>