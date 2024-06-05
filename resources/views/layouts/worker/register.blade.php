@extends('layouts.worker.layout')
@section('content')
    <div class=" flex w-full flex-col gap-4 p-4 rounded-md ">
        <div class="rounded-md text-center w-full bg-white py-4">
            <h1 class="text-xl font-bold m-0">Mendaftar</h1>
            <p>Isi data untuk mendaftar</p>
        </div>
        <form x-data="{ isSubmitting: false }" x-on:submit.prevent="isSubmitting = true; $el.submit()" method="post" action=""
            class="w-full gap-4 flex flex-col shadow-md bg-dark text-white rounded-md p-4">
            @csrf
            <div class="w-full">
                <label for="name" class="block mb-2 text-sm font-medium">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                    placeholder="John Doe" required />
            </div>
            <div class="w-full">
                <label for="email" class="block mb-2 text-sm font-medium">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                    placeholder="email@gmail.com" required />
            </div>
            <div class="w-full">
                <label for="position" class="block mb-2 text-sm font-medium">Jabatan</label>
                <select name="position" class="bg-pale text-dark text-sm rounded-lg w-full border-none focus:ring-main"
                    id="position" required>
                    <option selected value="" disabled>Pilih Jabatan</option>
                    @foreach ($positions as $position)
                        <option {{ old('position') == $position->id ? 'selected' : '' }} value="{{ $position->id }}">
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
                        <option {{ old('position') == $shift->id ? 'selected' : '' }} value="{{ $shift->id }}">
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
                        <option {{ old('position') == $shift->id ? 'selected' : '' }} value="{{ $location->id }}">
                            {{ $location->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-full">
                <label for="password" class="block mb-2 text-sm font-medium  ">Kata sandi</label>
                <input type="password" id="password" name="password"
                    class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                    placeholder="*******" required />
            </div>
            <input x-bind:disabled="isSubmitting" type="submit"
                class="mt-5 bg-main disabled:bg-pale disabled:text-dark p-2 w-full rounded-md" value="Mendaftar">
            <p class="text-sm">Sudah punya akun? <a class="text-main" href="/login">Masuk</a></p>
        </form>
    </div>
@endsection
