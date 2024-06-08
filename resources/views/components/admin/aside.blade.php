<aside id="default-sidebar" :class="{ 'translate-x-0 ': isOpen }"
    class="flex mt-[58px] z-50 sm:mt-0 !w-[200px] h-[calc(100vh-58px)] sm:h-screen transition-transform -translate-x-full absolute sm:static"
    aria-label="Sidebar">
    <div class="h-full px-3  overflow-y-auto bg-gray-50 w-full">
        <ul class="space-y-2 font-medium">
            <li class="hidden sm:block sm:mt-4">
                <article class="text-dark font-semibold whitespace-nowrap">PT MULLOP LONONG</article>
            </li>
            <li>
                <a href="{{ route('admin.employee') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg  hover:bg-gray-100 group">
                    <svg class="w-6 h-6 text-gray-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                            d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                    </svg>

                    <span class="ms-3">Karyawan</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg  hover:bg-gray-100 group">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z" />
                    </svg>

                    <span class="flex-1 ms-3 whitespace-nowrap">Jadwal</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

@push('script')
    <script></script>
@endpush
