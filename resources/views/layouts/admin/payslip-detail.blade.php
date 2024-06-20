@extends('layouts.admin.layout')
@section('content')
    <div class="w-full h-full overflow-y-scroll">
        <x-custom-table :$headers :source="$payslipDetails" :$pagination disableSearch="true">

        </x-custom-table>
    </div>
@endsection
