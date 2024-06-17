@extends('layouts.admin.layout')
{{-- @section('title')
    <h1 class="font-semibold text-lg">Data Form</h1>
@endsection --}}
@section('content')
    <div class="w-full h-full">
        <x-custom-table :$headers :source="$forms" :$pagination>
            <x-slot:add>
                <a href="{{ route('admin.master-form.tambah') }}"
                    class="flex rounded-md items-center ms-auto bg-complement text-sm text-white p-1">
                    <svg class="w-4 h-4 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 12h14m-7 7V5" />
                    </svg>Tambah</a>
            </x-slot:add>
            <x-slot:action>
                <div class="flex gap-1 text-sm">
                    <a class="rounded-md bg-main text-white p-1 flex items-center"
                        href="{{ route('admin.master-form.edit', '#target_id') }}">
                        <svg class="w-4 h-4 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                        </svg>
                        Edit</a>
                </div>
            </x-slot:action>
        </x-custom-table>

    </div>
@endsection
