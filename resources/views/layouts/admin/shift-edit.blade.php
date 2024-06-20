@extends('layouts.admin.layout')

@section('content')
    <div class="w-full h-full overflow-y-scroll grid sm:grid-cols-2">
        <form action="" method="post" class="gap-4 flex flex-col" x-data="{ isSubmitting: false }"
            x-on:submit.prevent="isSubmitting = true; $el.submit()">
            @method('put')
            @csrf
            <h1 class="font-semibold text-lg mb-2">Edit Data Jadwal</h1>
            <div class="w-full">
                <label for="name" class="block mb-2 text-sm font-medium">Nama</label>
                <input type="text" id="name" name="name" value="{{ $shift->name }}"
                    class="bg-gray-50 text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                    placeholder="John Doe" required />
            </div>
            <div class="w-full mb-2">
                <label for="clock_in" class="block mb-2 text-sm font-medium">Clock In</label>
                <input name="clock_in" type="time" id="time" value="{{ $shift->clock_in }}"
                    class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                    placeholder="Tanggal akhir payroll" required />
            </div>
            <div class="w-full mb-2">
                <label for="clock_out" class="block mb-2 text-sm font-medium">Clock Out</label>
                <input name="clock_out" type="time" id="time" value="{{ $shift->clock_out }}"
                    class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                    placeholder="Tanggal akhir payroll" required />
            </div>
            <div class="w-full mb-2">
                <label class="block mb-2 text-sm font-medium">Penalti Per Menit</label>
                <x-currency class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                    name="penalty_per_minutes" value="{{ $shift->penalty_per_minutes }}" />
            </div>
            <div class="w-full grid grid-cols-2 items-center gap-2">
                <input x-bind:disabled="isSubmitting" type="submit"
                    class=" bg-main disabled:bg-pale cursor-pointer text-white disabled:text-dark p-1  rounded-md"
                    value="Simpan">
                <a href="{{ route('admin.master-jadwal') }}"
                    class="bg-danger text-center p-1 rounded-md text-white">Batal</a>
            </div>
        </form>
    </div>
@endsection
