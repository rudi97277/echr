@extends('layouts.worker.layout')
@section('content')
    <div class="flex w-full flex-col gap-4 p-4 rounded-md">
        <div class="rounded-md text-center w-full bg-white py-4">
            <h1 class="text-lg font-bold m-0">Profile</h1>
        </div>
        <form x-data="{ isSubmitting: false }" x-on:submit.prevent="isSubmitting = true; $el.submit()" method="post" action=""
            class="w-full gap-4 flex flex-col shadow-md bg-white rounded-md p-4">
            @csrf
            <div class="w-full">
                <label for="name" class="block mb-2 text-sm font-medium">Nama</label>
                <input type="text" id="name" name="name" value="{{ $employee->name }}"
                    class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                    placeholder="John Doe" required />
            </div>
            <div class="w-full">
                <label for="email" class="block mb-2 text-sm font-medium">Email</label>
                <input type="email" id="email" name="email" value="{{ $employee->email }}"
                    class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                    placeholder="email@gmail.com" required />
            </div>
            <div class="w-full">
                <label for="position" class="block mb-2 text-sm font-medium">Jabatan</label>
                <select name="position" class="bg-pale text-dark text-sm rounded-lg w-full border-none focus:ring-main"
                    id="position" required>
                    <option selected value="" disabled>Pilih Jabatan</option>
                    @foreach ($positions as $position)
                        <option {{ $employee->position_id == $position->id ? 'selected' : '' }} value="{{ $position->id }}">
                            {{ $position->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full">
                <label for="shift" class="block mb-2 text-sm font-medium">Jam Kerja</label>
                <select name="shift" class="bg-pale text-dark text-sm rounded-lg w-full border-none focus:ring-main"
                    id="shift" required>
                    <option selected value="" disabled>Pilih Jam Kerja</option>
                    @foreach ($shifts as $shift)
                        <option {{ $employee->shift_id == $shift->id ? 'selected' : '' }} value="{{ $shift->id }}">
                            {{ $shift->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full">
                <label for="location" class="block mb-2 text-sm font-medium">Lokasi Kerja</label>
                <select name="location" class="bg-pale text-dark text-sm rounded-lg w-full border-none focus:ring-main"
                    id="location" required>
                    <option selected value="" disabled>Pilih Lokasi Kerja</option>
                    @foreach ($locations as $location)
                        <option {{ $employee->location_id == $location->id ? 'selected' : '' }} value="{{ $location->id }}">
                            {{ $location->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-full relative" x-data="{ inputType: 'password' }">
                <label for="password" class="block mb-2 text-sm font-medium  ">Kata sandi baru</label>
                <input :type="inputType" id="password" name="password" minlength="8"
                    class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                    placeholder="*******" autocomplete="new-password" />
                <button x-on:click="inputType = (inputType=== 'password') ? 'text' : 'password' "
                    class="text-dark text-sm absolute top-9 right-2" type="button"
                    x-text="inputType === 'password' ? 'Show' : 'Hide'"></button>
            </div>
            <input x-bind:disabled="isSubmitting" type="submit"
                class="mt-2 bg-main text-white disabled:bg-pale disabled:text-dark p-2 w-full rounded-md" value="Simpan">
        </form>

        <a href="{{ route('worker.logout') }}" class="bg-danger p-2 text-white text-center rounded-md">Logout</a>
    </div>
@endsection
