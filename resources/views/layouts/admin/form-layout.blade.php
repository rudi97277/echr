@extends('layouts.admin.layout')
@section('content')
    <div class="w-full h-full overflow-y-scroll mb-4">
        <h1 class="py-2 font-semibold text-lg">{{ $formName }}</h1>
        <form method="POST" action="" class="flex flex-col gap-2 px-1">
            @csrf
            @foreach ($components as $component)
                {!! $component !!}
            @endforeach
            <label for="amount" class="block text-sm font-medium">Harga Form <span class="text-xs text-dark">(tambahkan '-'
                    untuk tipe
                    pengurangan)</span> </label>

            <x-currency class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5  "
                name="amount" required="required" placeholder="Masukkan harga" value="{{ $formAmount }}" />
            <div>
                <input type="submit" value="Simpan" class="cursor-pointer bg-main p-2 mt-2 text-white text-sm rounded-md">
            </div>
        </form>
    </div>
@endsection
