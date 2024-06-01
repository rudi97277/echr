{{-- md:w-2/4 lg:w-1/3 --}}
@extends('layouts.worker-layout')
@section('content')
    <div class="flex w-full p-4 flex-col sm:flex-row items-center pb-[70px]">
        <div class="w-full flex flex-col gap-4">
            <div class="flex p-4 w-full flex-col justify-center items-center bg-white shadow-md rounded-md gap-4 text-dark">
                <div class=" rounded-md w-full flex flex-col gap-4 text-dark">
                    <div class="grid grid-cols-2 gap-3 items-center text-pale font-bold text-sm text-center">
                        <div class="bg-dark rounded-md p-2 ">
                            <p>3 hari</p>
                            <p class="font-medium">Total Hadir</p>
                        </div>
                        <div class="bg-dark rounded-md p-2">
                            <p>Rp 3.000.000</p>
                            <p class="font-medium">Total Pendapatan</p>
                        </div>
                        <div class="bg-dark rounded-md p-2">
                            <p>3 Fom</p>
                            <p class="font-medium">Pekerjaan</p>
                        </div>
                        <div class="bg-dark text-danger rounded-md p-2">
                            <p>- Rp 20.000</p>
                            <p class="font-medium">Total Denda</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center flex-col font-semibold text-md">
                    <p>Absensi</p>
                    <p class="font-normal">{{ $today }}</p>
                </div>
                <div class="flex flex-col gap-2 justify-evenly w-full rounded-md bg-dark text-white p-2 font-semibold">
                    <div class="flex w-full flex-col justify-center items-center">
                        <p class="text-sm font-bold">Rp 210.000</p>
                        <p class="text-xs font-semibold">Pendapatan</p>
                    </div>
                    <hr>
                    <div class="flex flex-row w-full">
                        <div class="flex flex-col justify-center items-center w-full ">
                            <p class="text-xs">Masuk</p>
                            <p>{{ $attendance?->clock_in ?? '--:--' }}</p>
                        </div>
                        <div class="flex flex-col justify-center items-center w-full">
                            <p class="text-xs">Keluar</p>
                            <p>{{ $attendance?->clock_out ?? '--:--' }}</p>
                        </div>
                    </div>
                </div>
                <button type="button" x-data="{ lat: 0, long: 0 }" x-init="if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        lat = position.coords.latitude
                        long = position.coords.longitude
                    });
                }"
                    {{ true || ($attendance?->clock_in != null && $attendance?->clock_out != null) ? 'disabled' : '' }}
                    wire:click="updateAttendance" wire:target="updateAttendance" wire:loading.attr="disabled"
                    class="bg-main w-full disabled:bg-pale disabled:text-dark text-white px-2 py-3 text-sm rounded-md font-bold">
                    <template x-if="lat == 0 && long == 0">
                        <span>Mendapatkan lokasi</span>
                    </template>
                </button>
            </div>
            <div class="flex flex-col gap-2 bg-white w-full p-4 rounded-md">
                <p class="font-semibold">Absensi 1 Minggu Terakhir</p>
                <hr>
                <div class="grid grid-cols-5 px-2 gap-y-1 ">
                    <p class="font-semibold col-span-3">Tanggal</p>
                    <p class="font-semibold">Masuk</p>
                    <p class="font-semibold">Keluar</p>
                    @if (count($attendances) == 0)
                        <p class="col-span-3">-----</p>
                        <p>--:--</p>
                        <p>--:--</p>
                    @endif
                    @foreach ($attendances as $item)
                        <p class="col-span-3">{{ $item->date }}</p>
                        <p>{{ $item?->clock_in ?? '--:--' }}</p>
                        <p>{{ $item?->clock_out ?? '--:--' }}</p>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script></script>
@endsection
