@extends('layouts.admin.layout')
@section('content')
    <div class="w-full h-full">
        <x-custom-table :$headers :source="$employees" :$pagination>
            <x-slot:action>
                <div class="flex gap-1">
                    <a class="rounded-md bg-main text-white p-2"
                        href="{{ route('admin.employee-edit', '#target_id') }}">Edit</a>
                    <a class="rounded-md bg-danger text-white p-2"
                        href="{{ route('admin.employee-edit', '#target_id') }}">Delete</a>
                </div>
            </x-slot:action>
        </x-custom-table>
    </div>
@endsection
@push('script')
    <script></script>
@endpush
