@extends('layouts.admin.layout')
{{-- @section('title')
    <h1 class="font-semibold text-lg">Data Master Jadwal</h1>
@endsection --}}
@section('content')
    <div class="w-full h-full overflow-y-scroll">

        <x-custom-table :$headers :source="$shifts" :$pagination withSearch="true">
            @scopedslot('action', $item)
                <div class="flex gap-1">
                    <a class="rounded-md bg-main text-white p-1 text-sm flex items-center"
                        href="{{ route('admin.master-jadwal.edit', AppHelper::obfuscate($item->id)) }}">
                        <svg class="w-4 h-4 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                        </svg>Edit</a>
                </div>
            @endscopedslot

            <x-slot:add>
                <button data-modal-target="modal" data-modal-toggle="modal"
                    class="text-white bg-complement text-sm rounded-md p-1 ms-auto flex justify-center items-center"
                    type="button">
                    <svg class="w-4 h-4 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 12h14m-7 7V5" />
                    </svg>
                    Tambah
                </button>
            </x-slot:add>
        </x-custom-table>
    </div>
    <div id="modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow ">
                <form action="" method="POST" class="p-4">
                    @csrf
                    <h1 class="font-semibold text-lg mb-2">Tambah Master Jadwal</h1>
                    <div class="w-full mb-2">
                        <label for="name" class="block mb-2 text-sm font-medium">Nama</label>
                        <input type="text" id="name" name="name"
                            class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                            placeholder="Nama jadwal" required />
                    </div>
                    <div class="w-full mb-2">
                        <label for="clock_in" class="block mb-2 text-sm font-medium">Clock In</label>
                        <input name="clock_in" type="time" id="time"
                            class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                            placeholder="Tanggal akhir payroll" required />
                    </div>
                    <div class="w-full mb-2">
                        <label for="clock_out" class="block mb-2 text-sm font-medium">Clock Out</label>
                        <input name="clock_out" type="time" id="time"
                            class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                            placeholder="Tanggal akhir payroll" required />
                    </div>
                    <div class="w-full mb-2">
                        <label class="block mb-2 text-sm font-medium">Penalti Per Menit</label>
                        <x-currency
                            class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                            name="penalty_per_minutes" />
                    </div>
                    <input type="submit" value="Simpan"
                        class="rounded-md p-2 bg-main text-sm text-white mt-4 cursor-pointer">
                </form>
            </div>
        </div>
    </div>
@endsection
