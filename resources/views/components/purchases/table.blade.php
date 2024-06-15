<div  class="flex justify-center">
    <table class="table-auto border-collapse mx-auto">
        <thead>
            <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
                <th class="px-2 py-2 text-left">Purchases ID</th>
                <th class="px-2 py-2 text-left">Date </th>
                <th class="px-2 py-2 text-left">Total Price</th>
                <th class="px-2 py-2 text-left">Customer Name</th>
                <th class="px-2 py-2 text-left">receipt_pdf_filename</th>
                @if($showView)
                    <th></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($purchases as $purchase)
                <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                    <td class="px-2 py-2 text-left">{{ $purchase->id}}</td>
                    <td class="px-2 py-2 text-left">{{ $purchase->date }}</td>
                    <td class="px-2 py-2 text-left">{{ $purchase->total_price }}</td>
                    <td class="px-2 py-2 text-left">{{ $purchase->customer_name }}</td>
                    <td class="px-2 py-2 text-left">{{ $purchase->receipt_pdf_filename }}</td>
                    
                    @if($showView)
                        <td class="text-center">
                            <x-table.icon-show class="ps-3 px-0.5" href="{{ route('purchases.show', ['purchase' => $purchase]) }}" />
                        </td>
                    @endif
                    
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

