<aside id="default-sidebar" :class="{ 'translate-x-0 ': isOpen }"
    class="flex mt-[58px] z-50 sm:mt-0 !w-[200px] h-[calc(100vh-58px)] sm:h-screen transition-transform -translate-x-full absolute sm:static"
    aria-label="Sidebar">
    <div class="h-full px-3  overflow-y-auto bg-gray-50 w-full">
        <ul class="space-y-2 font-medium">
            <li class="hidden sm:block sm:mt-4">
                <article class="text-dark font-semibold whitespace-nowrap">PT MULLOP LONONG</article>
            </li>
            <li class="">
                <a href="{{ route('admin.employee') }}"
                    class="flex items-center p-2 rounded-lg border border-transparent hover:border-dark {{ request()->routeIs('admin.employee') || request()->routeIs('admin.employee-edit') ? 'bg-dark text-white group' : '' }}">
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                            d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                    </svg>

                    <span class="ms-3">Karyawan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.shift') }}"
                    class="flex items-center p-2 text-gray-900 border border-transparent hover:border-dark rounded-lg  {{ request()->routeIs('admin.shift') ? 'bg-dark text-white group' : '' }}">
                    <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z" />
                    </svg>

                    <span class="flex-1 ms-3 whitespace-nowrap">Jadwal</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.position') }}"
                    class="flex items-center p-2 text-gray-900 border border-transparent hover:border-dark rounded-lg  {{ request()->routeIs('admin.position') ? 'bg-dark text-white group' : '' }}">
                    <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7H5a2 2 0 0 0-2 2v4m5-6h8M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m0 0h3a2 2 0 0 1 2 2v4m0 0v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-6m18 0s-4 2-9 2-9-2-9-2m9-2h.01" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Jabatan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.location') }}"
                    class="flex items-center p-2 text-gray-900 border border-transparent hover:border-dark rounded-lg  {{ request()->routeIs('admin.location') ? 'bg-dark text-white group' : '' }}">
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.8 13.938h-.011a7 7 0 1 0-11.464.144h-.016l.14.171c.1.127.2.251.3.371L12 21l5.13-6.248c.194-.209.374-.429.54-.659l.13-.155Z" />
                    </svg>

                    <span class="flex-1 ms-3 whitespace-nowrap">Lokasi</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

@push('script')
    <script></script>
@endpush
