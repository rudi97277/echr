@extends('layouts.worker.layout')
@section('content')
    <div class="bg-white w-full p-4 rounded-md mt-2">
        <table class="w-full border-separate border-spacing-y-2">
            <thead>
                <tr class="text-left">
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach ($details as $idx => $detail)
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td>{{ $detail->name }}</td>
                        <td class="text-right">{!! AppHelper::formatRupiah($detail->amount) !!}</td>
                    </tr>
                    @php
                        $total += $detail->amount;
                    @endphp
                @endforeach
                <tr>
                    <th colspan="2" class="text-left">Total</th>
                    <th class="text-right">{!! AppHelper::formatRupiah($total) !!}</th>
                </tr>
            </tbody>
        </table>
        <a href="{{ route('worker.payslip') }}"
            class="flex w-full justify-center bg-main text-white rounded-md p-1">Kembali</a>
    </div>
@endsection
