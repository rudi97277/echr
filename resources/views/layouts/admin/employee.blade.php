@extends('layouts.admin.layout')
@section('content')
    <div class="w-full h-full">
        <x-custom-table :$headers :source="$employees" :$pagination>
            <x-slot:action>
                <div class="flex gap-1 text-xs">
                    <a href="{{ route('admin.karyawan.absensi', '#target_id') }}"
                        class="flex items-center bg-complement text-white rounded-md p-1">
                        <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z" />
                        </svg>
                        Absensi
                    </a>
                    <a class="rounded-md bg-main text-white p-1 flex items-center"
                        href="{{ route('admin.karyawan.edit', '#target_id') }}">
                        <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                        </svg>
                        Edit</a>
                    {{-- <a class="rounded-md bg-danger text-white p-1 flex items-center"
                        href="{{ route('admin.karyawan.edit', '#target_id') }}">
                        <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                        </svg>
                        Hapus</a> --}}
                </div>
            </x-slot:action>

            <x-slot:add>
                <a href="" class="bg-complement text-white ms-auto rounded-md px-2 py-2 flex text-sm items-center">
                    <svg class="w-4 h-4 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 12h14m-7 7V5" />
                    </svg>
                    Tambah
                </a>
            </x-slot:add>
        </x-custom-table>
    </div>
@endsection
