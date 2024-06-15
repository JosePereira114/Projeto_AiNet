<div {{ $attributes }}>
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left">Photo</th>
            <th class="px-2 py-2 text-left">Name</th>
            @if($showView)
                <th></th>
            @endif
            @if($showEdit)
                <th></th>
            @endif
            @if($showDelete)
                <th></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($theaters as $theater)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
            <td class="px-2 py-2 text-left">
                    <img src="{{$theater->photoFullUrl}}"alt="Theater Photo" width="75">
                </td>
                <td class="px-2 py-2 text-left">{{ $theater->name }}</td>
                
                @if($showView)
                    <td>
                        <x-table.icon-show class="ps-3 px-0.5"
                        href="{{ route('theaters.show', ['theater' => $theater]) }}"/>
                    </td>
                @endif
                @if($showEdit)
                @can('update', App\Models\Theater::class)
                    <td>
                        <x-table.icon-edit class="px-0.5"
                        href="{{ route('theaters.edit', ['theater' => $theater]) }}"/>
                    </td>
                @endcan
                @endif
                @if($showDelete)
                @can('delete', App\Models\Theater::class)
                    <td>
                        <x-table.icon-delete class="px-0.5"
                        action="{{ route('theaters.destroy', ['theater' => $theater]) }}"/>
                    </td>
                @endcan
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
