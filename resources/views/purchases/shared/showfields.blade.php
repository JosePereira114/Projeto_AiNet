@php
$mode = $mode ?? 'edit';
$readonly = $mode == 'show';
@endphp
<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="date" label="Date" width="md" :readonly="$readonly" value="{{ old('date', $purchase->date) }}" />
        <x-field.input name="total_price" label="Total Price" width="md" :readonly="$readonly" value="{{ old('total_price', $purchase->total_price) }}" />
        <x-field.input name="customer_name" label="Customer Name" width="md" :readonly="$readonly" value="{{ old('customer_name', $purchase->customer_name) }}" />
        <x-field.input name="customer_email" label="Customer Email" width="md" :readonly="$readonly" value="{{ old('receipt_pdf_filename', $purchase->customer_email) }}" />
        <x-field.input name="payment_type" label="Payment Type" width="md" :readonly="$readonly" value="{{ old('payment_type', $purchase->payment_type) }}" />
        <x-field.input name="payment_ref" label="Payment Ref" width="md" :readonly="$readonly" value="{{ old('payment_ref', $purchase->payment_ref) }}" />
        <x-field.input name="receipt_pdf_filename" label="receipt_pdf_filename" width="md" :readonly="$readonly" value="{{ old('receipt_pdf_filename', $purchase->receipt_pdf_filename) }}" />
    </div>
    
</div>