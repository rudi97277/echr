@extends('layouts.admin.layout')
@section('content')
    <div class="w-full h-full">
        <h1 class="py-2 font-semibold text-lg">{{ $formName }}</h1>
        <form method="POST" action="" class="flex flex-col gap-2">
            @csrf
            @foreach ($components as $component)
                {!! $component !!}
            @endforeach
            <div>
                <input type="submit" value="Simpan" class="cursor-pointer bg-main p-2 mt-2 text-white text-sm rounded-md">
            </div>
        </form>
    </div>
@endsection
