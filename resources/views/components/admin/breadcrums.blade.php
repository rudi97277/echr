<div class="flex">
    @yield('title')
    <div class="flex text-sm bg-pale py-1 px-2 rounded-md mb-4 ms-auto font-semibold gap-1 items-center">
        <a href="{{ route('admin.master-karyawan') }}">Admin</a>
        <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m9 5 7 7-7 7" />
        </svg>
        @foreach (AppHelper::breadcrumbs() as $idx => $item)
            <a href="{{ $item['url'] }}">{{ $item['name'] }}</a>
            @if (count(AppHelper::breadcrumbs()) > $idx + 1)
                <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m9 5 7 7-7 7" />
                </svg>
            @endif
        @endforeach
    </div>

</div>
