@extends('layouts.worker.layout')
@section('content')
    <div>
        <div class="p-4 relative border justify-center rounded-b-md border-mWhite shadow-md font-semibold flex">
            <a href="{{ route('worker.payslip') }}" class="absolute left-4">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m15 19-7-7 7-7" />
                </svg>
            </a>
            Detail Payslip
        </div>

        <div class="bg-white w-full p-4 rounded-md gap-4 flex flex-col">
            <div class="p-2 px-4 rounded-md  shadow-lg border-main border">
                <div class="grid grid-cols-2 gap-2">
                    <p class="font-semibold">Nama</p>
                    <p>{{ $employee->name }}</p>
                    <p class="font-semibold">Posisi</p>
                    <p>{{ $employee->position }}</p>
                    <p class="font-semibold">Total Hadir</p>
                    <p>{{ $workday }} hari</p>
                </div>
            </div>

            <div class="p-2 px-4 rounded-md border-main border shadow-lg">
                <div class="grid grid-cols-2 gap-2">
                    <p class="col-span-2 font-semibold">Detail Penghasilan</p>
                    <hr class="col-span-2 border-dashed border-t-2">
                    @foreach ($details as $detail)
                        <p>{{ $detail->name }}</p>
                        <p class="text-right">{!! AppHelper::formatRupiah($detail->amount) !!}</p>
                    @endforeach
                    <hr class="col-span-2 border-dashed border-t-2">
                    <p class="font-semibold">Total</p>
                    <p class="text-right">{!! AppHelper::formatRupiah($total) !!}</p>
                </div>
            </div>

        </div>
    </div>
@endsection
