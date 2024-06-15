@extends('layouts.admin.layout')
@section('content')
    <div class="w-full h-full">
        <x-month-picker />
        <x-custom-table :$headers :source="$attendances" :$pagination disableSearch="true" />
    </div>
@endsection