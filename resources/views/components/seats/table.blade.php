<div {{ $attributes }}>
    {{$screening=0}}
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left hidden sm:table-cell">Movie</th>
            <th class="px-2 py-2 text-left">Number</th>
            <th class="px-2 py-2 text-right hidden md:table-cell">Theater</th>
            @if($showView)
                <th></th>
            @endif
            @if($showEdit)
                <th></th>
            @endif
            @if($showDelete)
                <th></th>
            @endif
            @if($showAddToCart)
                <th></th>
            @endif
            @if($showRemoveFromCart)
                <th></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($seats as $seat)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-left hidden sm:table-cell">{{ $seat->movie ? $seat->movie->title : 'N/A' }}</td>
                <td class="px-2 py-2 text-left">{{ $seat }}</td>
                <td class="px-2 py-2 text-right hidden md:table-cell">{{ $seat->theater ? $seat->theater->name : 'N/A'}}</td>
                @if($showView)
                    <td>
                        <x-table.icon-show class="ps-3 px-0.5"
                        href="{{ route('seats.show', ['seat' => $seat]) }}"/>
                    </td>
                @endif
                @if($showEdit)
                    <td>
                        <x-table.icon-edit class="px-0.5"
                        href="{{ route('seats.edit', ['seat' => $seat]) }}"/>
                    </td>
                @endif
                @if($showDelete)
                    <td>
                        <x-table.icon-delete class="px-0.5"
                        action="{{ route('seats.destroy', ['seat' => $seat]) }}"/>
                    </td>
                @endif
                @if($showAddToCart)
                    <td>
                        <x-table.icon-add-cart class="px-0.5"
                            method="post"
                            action="{{ route('cart.add', ['seat' => $seat]) }}"/>
                    </td>
                @endif
                @if($showRemoveFromCart)
                    <td>
                        <x-table.icon-minus class="px-0.5"
                            method="delete"
                            action="{{ route('cart.remove', ['screening' => $screening]) }}"/>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
