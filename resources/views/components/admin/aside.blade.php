<aside id="default-sidebar" :class="{ 'translate-x-0 ': isOpen }"
    class="flex mt-[58px] z-40 sm:mt-0 !w-[200px] h-[calc(100vh-58px)] sm:h-screen transition-transform -translate-x-full absolute sm:static"
    aria-label="Sidebar">
    <div class="h-full px-3 text-mWhite font-semibold  overflow-y-auto bg-mDark w-full">
        <ul class="space-y-2">
            <li class="hidden sm:block sm:mt-4">
                <article class=" text-center uppercase  whitespace-nowrap">
                    {{ AppHelper::webName() }}
                </article>
                <hr class="border-dashed border-mGray border-t-2 mt-2">
            </li>
            <li>
                <button type="button"
                    class="flex items-center w-full p-2 text-base  transition duration-75 rounded-lg group "
                    aria-controls="master-data" data-collapse-toggle="master-data">
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                            d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                    </svg>
                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Data Master</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <ul id="master-data" class="py-2 space-y-2 pl-6">
                    <li>
                        <a href="{{ route('admin.master-karyawan') }}"
                            class="flex items-center w-full p-2  transition duration-75 rounded-lg hover:border-dark {{ request()->routeIs('admin.master-karyawan*') ? 'bg-dark text-white group' : '' }} ">Karyawan</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.master-jadwal') }}"
                            class="flex items-center w-full p-2  transition duration-75 rounded-lg hover:border-dark {{ request()->routeIs('admin.master-jadwal*') ? 'bg-dark text-white group' : '' }} ">Jadwal</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.master-jabatan') }}"
                            class="flex items-center w-full p-2  transition duration-75 rounded-lg hover:border-dark {{ request()->routeIs('admin.master-jabatan*') ? 'bg-dark text-white group' : '' }} ">Jabatan</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.master-lokasi') }}"
                            class="flex items-center w-full p-2  transition duration-75 rounded-lg hover:border-dark {{ request()->routeIs('admin.master-lokasi*') ? 'bg-dark text-white group' : '' }} ">Lokasi</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.master-form') }}"
                            class="flex items-center w-full p-2  transition duration-75 rounded-lg hover:border-dark {{ request()->routeIs('admin.master-form*') ? 'bg-dark text-white group' : '' }} ">Form</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('admin.form') }}"
                    class="flex items-center p-2  border border-transparent hover:border-dark rounded-lg  {{ request()->routeIs('admin.form*') ? 'bg-dark text-white group' : '' }}">
                    <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-3 5h3m-6 0h.01M12 16h3m-6 0h.01M10 3v4h4V3h-4Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Form</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.payslip') }}"
                    class="flex items-center p-2  border border-transparent hover:border-dark rounded-lg  {{ request()->routeIs('admin.payslip*') ? 'bg-dark text-white group' : '' }}">
                    <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                            d="M8 7V6a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1h-1M3 18v-7a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Payslip</span>
                </a>
            </li>


        </ul>
    </div>
</aside>

@push('script')
    <script></script>
@endpush
