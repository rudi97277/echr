@extends('layouts.worker.layout')
@section('content')
    <div class="flex flex-col gap-3 w-full p-2">
        @foreach ($payslips as $payslip)
            <a href="{{ route('worker.payslip.detail', AppHelper::obfuscate($payslip['id'])) }}"
                class="bg-white shadow-md w-full rounded-md p-2">
                <div class="flex">
                    <p class="font-semibold">{{ $payslip['name'] }}</p>
                    <p class="ms-auto">{{ $payslip['date'] }}</p>
                </div>
                <p>{!! $payslip['total'] !!}</p>
            </a>
        @endforeach
    </div>
@endsection
