@extends('layouts.worker-layout')
@section('content')
    <div class="bg-dark m-4 rounded-md p-4">
        <div date-rangepicker class="flex justify-between items-center bg-main rounded-md text-dark">
            <input class="max-w-[120px] border-none focus:ring-transparent outline-none rounded-s-md bg-pale" name="start"
                type="text" value="08/04/2024">
            <div>
                <svg class="h-6 w-12 text-dark" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 12H5m14 0-4 4m4-4-4-4" />
                </svg>
            </div>
            <input class="max-w-[120px] border-none focus:ring-transparent bg-pale " name="end" type="text"
                placeholder="02/25/2022">
            <button class="flex justify-center w-full">
                <svg class="w-6 h-6 text-dark" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                        d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                </svg>
            </button>
        </div>
    </div>


    </div>
@endsection
