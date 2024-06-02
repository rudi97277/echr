<div class="fixed bottom-0 left-0 z-50 w-full h-16 border-t border-gray-200 ">
    <div class="flex justify-center items-center h-full bg-white max-w-[400px] grid-cols-4 mx-auto font-medium">
        <a href="/" type="button"
            class="inline-flex flex-col items-center {{ url()->current() === route('home') ? 'text-complement' : '' }} items-center justify-center px-5">
            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5" />
            </svg>
            <span class="text-sm">Home</span>
        </a>
        <a href="/history" type="button"
            class="inline-flex flex-col items-center {{ url()->current() === route('history') ? 'text-complement' : 'text-dark' }} items-center justify-center px-5">
            <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 3v4a1 1 0 0 1-1 1H5m4 10v-2m3 2v-6m3 6v-3m4-11v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z" />
            </svg>


            <span class="text-sm">Riwayat</span>
        </a>

        <a href="/history" type="button"
            class="inline-flex flex-col items-center {{ url()->current() === route('history') ? 'text-complement' : 'text-dark' }} items-center justify-center px-5">
            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2"
                    d="M10 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h2m10 1a3 3 0 0 1-3 3m3-3a3 3 0 0 0-3-3m3 3h1m-4 3a3 3 0 0 1-3-3m3 3v1m-3-4a3 3 0 0 1 3-3m-3 3h-1m4-3v-1m-2.121 1.879-.707-.707m5.656 5.656-.707-.707m-4.242 0-.707.707m5.656-5.656-.707.707M12 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
            <span class="text-sm">Pengaturan</span>
        </a>

        <a href="/history" type="button"
            class="inline-flex flex-col items-center {{ url()->current() === route('history') ? 'text-complement' : 'text-dark' }} items-center justify-center px-5">
            <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 9h3m-3 3h3m-3 3h3m-6 1c-.306-.613-.933-1-1.618-1H7.618c-.685 0-1.312.387-1.618 1M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm7 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" />
            </svg>


            <span class="text-sm">Profile</span>
        </a>
    </div>
</div>
