<div {{ $attributes }}>
    
    <table class="table-auto border-collapse">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left hidden sm:table-cell">Screening ID</th>
            <th class="px-2 py-2 text-left">Movie</th>
            <th class="px-2 py-2 text-right hidden md:table-cell">Theater</th>
            <th class="px-2 py-2 text-left">Date</th>
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
        @foreach ($screenings as $screening)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
            <td class="px-2 py-2 text-left hidden sm:table-cell">{{ $screening->id }}</td>
                <td class="px-2 py-2 text-left hidden sm:table-cell">{{ $screening->movie->title }}</td>
                <td class="px-2 py-2 text-right hidden md:table-cell">{{ $screening->theater->name }}</td>
                <td class="px-2 py-2 text-left">{{ $screening->date }}</td>
                @if($showView)
                    <td>
                        <x-table.icon-show class="ps-3 px-0.5"
                        href="{{ route('screenings.show', ['screening' => $screening]) }}"/>
                    </td>
                @endif
                @if($showEdit)
                    <td>
                        <x-table.icon-edit class="px-0.5"
                        href="{{ route('screenings.edit', ['screening' => $screening]) }}"/>
                    </td>
                @endif
                @if($showDelete)
                    <td>
                        <x-table.icon-delete class="px-0.5"
                        action="{{ route('screenings.destroy', ['screening' => $screening]) }}"/>
                    </td>
                @endif
               
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
