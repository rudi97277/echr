@extends('layouts.admin.layout')
@section('content')
    <div class="w-full h-full">
        <x-custom-table :$headers :source="$forms" :$pagination disableSearch="true">
            <x-slot:add>
                <form action="{{ route('admin.form.tambah') }}" class="flex pb-4 ms-auto gap-2">
                    <select name="target" class="bg-pale text-dark text-sm rounded-lg w-full border-none focus:ring-main"
                        required>
                        <option selected value="" disabled>Pilih Jenis Form</option>
                        @foreach ($formType as $item)
                            <option value="{{ AppHelper::obfuscate($item->id) }}">
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                    <input type="submit" value="Tambah"
                        class="bg-complement cursor-pointer text-white rounded-md px-2 py-2 flex text-sm items-center">
                </form>
            </x-slot:add>
            <x-slot:action>
                <div class="flex gap-1 ">
                    <a class="rounded-md bg-main text-white p-1  flex items-center"
                        href="{{ route('admin.form.edit', '#target_id') }}">
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
