@extends('layouts.admin.layout')
@section('content')
    <div class="w-full h-full">
        <x-table :headers="$headers" :data="$employees" :$pagination />
    </div>
@endsection
@push('script')
    <script></script>
@endpush
