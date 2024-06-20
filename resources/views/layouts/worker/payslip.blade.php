@extends('layouts.worker.layout')
@section('content')
    <div>
        <div class="p-4 border text-center rounded-b-md border-mWhite shadow-md font-semibold">Riwayat Payslip</div>
        <div class="flex flex-col gap-4 p-4">
            @foreach ($payslips as $payslip)
                <div class="flex">
                    <div class="w-[12px] rounded-s-md {{ $payslip['total_number'] > 0 ? 'bg-complement' : 'bg-danger' }} ">
                    </div>
                    <a href="{{ route('worker.payslip.detail', AppHelper::obfuscate($payslip['id'])) }}"
                        class="bg-white shadow-md w-full border border-main rounded-e-md p-2 ">
                        <div class="flex">
                            <p class="font-semibold">{{ $payslip['name'] }}</p>
                            <p class="ms-auto text-sm">{{ $payslip['date'] }}</p>
                        </div>
                        <p class="text-sm">{!! $payslip['total'] !!}</p>
                    </a>
                </div>
            @endforeach
            @if (count($payslips) < 1)
                <div class="bg-white flex justify-center p-4 rounded-md text-sm">
                    --- Payslip Kosong ---
                </div>
            @endif
        </div>
    </div>
@endsection
