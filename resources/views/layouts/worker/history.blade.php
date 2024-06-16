@extends('layouts.worker.layout')
@section('content')
    <div>
        <div class="bg-dark m-4 rounded-md p-4">
            <form action="" id="form-search" x-data="{ isSubmitting: false }"
                x-on:submit.prevent="isSubmitting = true; $el.submit()" action="" date-rangepicker datepicker-autohide
                datepicker-format="dd/mm/yyyy" method="get" class="flex justify-between bg-pale rounded-md text-dark">
                <div class="flex">
                    <input class="max-w-[120px] border-none focus:ring-transparent outline-none rounded-s-md bg-pale"
                        name="start_date" type="text" value="{{ $start ?? '' }}">
                </div>
                <div class="flex items-center">
                    <svg class="h-6 w-6 text-dark" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 12H5m14 0-4 4m4-4-4-4" />
                    </svg>
                </div>
                <div class="flex">
                    <input class="max-w-[120px] border-none focus:ring-transparent bg-pale " name="end_date" type="text"
                        value="{{ $end ?? '' }}">
                </div>
                <div :class="{ 'bg-main': !isSubmitting, 'bg-white': isSubmitting }"
                    class="flex rounded-e-md flex-1 items-center">
                    <label for="search" class="w-full cursor-pointer flex justify-center">
                        <svg :class="{ 'text-pale': !isSubmitting, 'text-dark': isSubmitting }" class="w-6 h-6 "
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                        </svg>
                    </label>
                    <input id="search" type="submit" value="">
                </div>
            </form>
        </div>
        <div class="flex flex-col gap-4 rounded-md px-4">
            @foreach ($attendances as $attendance)
                <div class="flex flex-row text-sm">
                    <div class="w-[12px] rounded-s-xl {{ $attendance->in_minutes > 0 ? 'bg-danger' : 'bg-complement' }} ">
                    </div>
                    <div class="flex w-full gap-1 flex-col p-2 rounded-e-xl bg-white shadow-md">
                        <div class="flex">
                            <p>{{ $attendance->date }}</p>
                            @if ($attendance->in_minutes > 0)
                                <p class="ms-auto text-xs text-danger p-1 rounded-md">
                                    - Rp {{ number_format($attendance->deduction, 0, ',', '.') }}
                                </p>
                            @endif
                        </div>
                        <div class="flex gap-2">
                            <p>⏳ {{ $attendance->in_at }}
                            </p>
                            <p>⌛ {{ $attendance?->out_at ?? '--:--' }}</p>

                        </div>
                    </div>
                </div>
            @endforeach
            @if (count($attendances) < 1)
                <div class="bg-white flex justify-center p-4 rounded-md text-sm">
                    --- Absensi Kosong ---
                </div>
            @endif
        </div>
    @endsection
