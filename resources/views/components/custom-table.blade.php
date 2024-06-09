@props(['headers', 'data', 'pagination', 'action'])

<div class="w-full h-full flex flex-col">
    <form action="" class="pb-4 relative bg-white flex items-center">
        <svg class="w-4 h-4 absolute text-gray-500 left-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
        </svg>
        <input type="text" id="table-search" name="keyword"
            class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 "
            placeholder="Search for items" value="{{ request()->keyword }}">
    </form>
    <div class="overflow-scroll w-full">
        <table class="w-full h-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-2">No</th>
                    @foreach ($headers ?? [] as $head)
                        <th scope="col" class="px-6 py-3">
                            {{ $head }}
                        </th>
                    @endforeach
                    @if ($action->isNotEmpty())
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($source ?? [] as $index => $item)
                    <tr class="bg-white border-b text-dark hover:bg-gray-50 ">
                        <td class="px-2">{{ $index + $pagination['from'] }}</td>
                        @foreach (collect($item) as $key => $value)
                            @if ($key !== 'id')
                                <td class="px-6 py-4">
                                    {{ $value }}
                                </td>
                            @else
                                <?php $setCurrentId($value); ?>
                            @endif
                        @endforeach
                        <td>
                            @if ($action->isNotEmpty())
                                {!! str_replace('#target_id', $getCurrentId(), $action) !!}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <div class="text-sm py-3 border-t border-t-gray-200 flex pe-2">
        <p class="">Data {{ $pagination['from'] ?? 0 }} sampai {{ $pagination['to'] ?? 0 }}</p>
        <div class="ms-auto flex items-center gap-1">
            @if ($pagination['prev_page_url'])
                <a href="{{ $pagination['prev_page_url'] }}">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m15 19-7-7 7-7" />
                    </svg>
                </a>
            @endif

            <form action="" class="flex gap-2">
                <input class="text-sm border-pale w-[25px] block text-center p-0 m-0 rounded-md"
                    max="{{ $pagination['last_page'] }}" type="number" name="page"
                    value="{{ $pagination['current_page'] }}">

                <p>dari</p>
                <p read class="text-sm border border-pale w-[25px] text-center p-0 m-0 rounded-md">
                    {{ $pagination['last_page'] }}</p>
            </form>

            @if ($pagination['next_page_url'])
                <a href="{{ $pagination['next_page_url'] }}">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m9 5 7 7-7 7" />
                    </svg>
                </a>
            @endif

        </div>
    </div>

</div>
