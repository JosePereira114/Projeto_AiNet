<div {{ $attributes }} class="flex justify-center">
    <table class="table-auto border-collapse mx-auto">
        <thead>
            <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
                <th class="px-2 py-2 text-left">Title Movie</th>
                <th class="px-2 py-2 text-left">Theater Name</th>
                <th class="px-2 py-2 text-left">Date</th>
                <th class="px-2 py-2 text-left">Time</th>
                <th class="px-2 py-2 text-left">Price</th>
                <th class="px-2 py-2 text-left">Buy at</th>
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
            @foreach ($tickets as $ticket)
                <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                    <td class="px-2 py-2 text-left">{{ $ticket->screening->movie->title }}</td>
                    <td class="px-2 py-2 text-left">{{ $ticket->screening->theater->name }}</td>
                    <td class="px-2 py-2 text-left">{{ $ticket->screening->date }}</td>
                    <td class="px-2 py-2 text-left">{{ $ticket->screening->start_time }}</td>
                    <td class="px-2 py-2 text-left">{{ $ticket->price }}</td>
                    <td class="px-2 py-2 text-left">{{ $ticket->created_at }}</td>
                    
                    @if($showView)
                        <td class="text-center">
                            <x-table.icon-show class="ps-3 px-0.5" href="{{ route('tickets.show', ['ticket' => $ticket]) }}" />
                        </td>
                    @endif
                    @if($showEdit)
                        <td class="text-center">
                            <x-table.icon-edit class="px-0.5" href="{{ route('tickets.edit', ['ticket' => $ticket]) }}" />
                        </td>
                    @endif
                    @if($showDelete)
                        <td class="text-center">
                            <x-table.icon-delete class="px-0.5" action="{{ route('tickets.destroy', ['ticket' => $ticket]) }}" />
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

