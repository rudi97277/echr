@extends('layouts.admin.layout')

@section('content')
    <div class="w-full h-full">
        <div class="grid sm:grid-cols-2 gap-4 pb-2">
            <div>
                <h1 class="font-semibold text-lg">Preview {{ $formName }}</h1>
                <div class="flex flex-col gap-2">
                    @foreach ($components as $component)
                        {!! $component !!}
                    @endforeach

                </div>
            </div>
            <div action="" class="gap-2 flex flex-col">
                <h1 class="font-semibold text-lg mb-2">Data Form</h1>
                <form method="post" action="">
                    @method('put')
                    @csrf
                    <div class="w-full flex flex-col gap-2 mb-2">
                        <input type="text" name="name" value="{{ $formName }}"
                            class="bg-pale border-none rounded-md text-sm" placeholder="Isi nama form" required>
                        <div class="grid grid-cols-2 gap-2">
                            <x-currency class="border-none bg-pale rounded-md text-sm w-full" value="{{ $formAmount }}"
                                name="amount" placeholder="Harga per form" required="required" />
                            <input type="submit" class="bg-complement text-white rounded-md p-1 text-sm" value="Simpan">
                        </div>

                    </div>
                    <div class="flex gap-2">
                        <x-custom-table :headers="['Nama']" :source="$formComponents" :pagination="$pagination ?? []" disableSearch="true">
                            <x-slot:action>
                                <div x-data="{ isChecked: '#target_check' }">
                                    <input type="checkbox" :checked="isChecked" value="#target_id" name="components[]"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded ">
                                </div>
                            </x-slot:action>
                        </x-custom-table>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
