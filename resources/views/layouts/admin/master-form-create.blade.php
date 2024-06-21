@extends('layouts.admin.layout')

@section('content')
    <div class="w-full h-full overflow-y-auto p-4">
        <div class="grid sm:grid-cols-2 gap-4 pb-4">
            <div>
                <h1 class="font-semibold text-lg">Tampilan Komponen </h1>
                <div class="flex flex-col gap-2">
                    @foreach ($components as $component)
                        {!! $component !!}
                    @endforeach
                </div>
            </div>
            <div action="" class="gap-2 flex flex-col">
                <h1 class="font-semibold text-lg mb-2">Data Form</h1>
                <form method="post" action="{{ route('admin.master-form.store') }}">
                    @csrf
                    <div class="w-full flex flex-col gap-2 mb-2">
                        <input type="text" name="name" value="" class="bg-pale border-none rounded-md text-sm"
                            placeholder="Isi nama form" required>
                        <div class="grid grid-cols-2 gap-2">
                            <x-currency class="border-none bg-pale rounded-md text-sm w-full" name="amount"
                                placeholder="Harga per form" />
                            <input type="submit" class="bg-complement text-white rounded-md p-1 text-sm" value="Simpan">
                        </div>

                    </div>
                    <div class="flex gap-2">
                        <x-custom-table :headers="['Nama']" :source="$formComponents" :pagination="$pagination ?? []" disableSearch="true">
                            @scopedslot('action', $item)
                                <div>
                                    <input type="checkbox" value="{{ $item->id }}" name="components[]"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded ">
                                </div>
                            @endscopedslot
                        </x-custom-table>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
