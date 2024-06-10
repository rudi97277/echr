@extends('layouts.admin.layout')
@section('content')
    <div class="w-full h-full">
        <x-custom-table :$headers :source="$shifts" :$pagination>
            <x-slot:action>
                <div class="flex gap-1">
                    <a class="rounded-md bg-main text-white p-2" href="{{ route('admin.shift-edit', '#target_id') }}">Edit</a>
                    <a class="rounded-md bg-danger text-white p-2"
                        href="{{ route('admin.shift-edit', '#target_id') }}">Delete</a>
                </div>
            </x-slot:action>

            <x-slot:add>
                <a href="" class="bg-complement text-white ms-auto rounded-md px-2 py-2 flex text-sm items-center">
                    <svg class="w-4 h-4 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 12h14m-7 7V5" />
                    </svg>
                    Tambah
                </a>
            </x-slot:add>
        </x-custom-table>
    </div>
@endsection
