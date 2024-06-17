@extends('layouts.worker.layout')
@section('content')
    <div class="flex flex-col gap-3 w-full p-4">
        <div class="rounded-md text-center w-full bg-white py-4 mb-2">
            <h1 class="text-lg font-bold m-0">Payslip</h1>
        </div>
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
        @if (count($payslips) < 1)
            <div class="bg-white flex justify-center p-4 rounded-md text-sm">
                --- Payslip Kosong ---
            </div>
        @endif
    </div>
@endsection
