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
                    placeholder="Isi nama lengkap" required />
            </div>
            <div class="w-full">
                <label for="email" class="block mb-2 text-sm font-medium">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                    placeholder="email@gmail.com" required />
            </div>
            <div class="w-full">
                <label for="bank_name" class="block mb-2 text-sm font-medium">Nama Bank</label>
                <input type="bank_name" id="bank_name" name="bank_name" value="{{ old('bank_name') }}"
                    class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                    placeholder="BCA" />
            </div>
            <div class="w-full">
                <label for="bank_number" class="block mb-2 text-sm font-medium">Nomor Bank</label>
                <input type="bank_number" id="bank_number" name="bank_number" value="{{ old('bank_number') }}"
                    class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                    placeholder="0101020203030" />
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
                        <option {{ old('shift') == $shift->id ? 'selected' : '' }} value="{{ $shift->id }}">
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
                        <option {{ old('location') == $location->id ? 'selected' : '' }} value="{{ $location->id }}">
                            {{ $location->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-full relative" x-data="{ inputType: 'password' }">
                <label for="password" class="block mb-2 text-sm font-medium  ">Kata sandi</label>
                <input :type="inputType" id="password" name="password"
                    class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                    placeholder="*******" required minlength="8" />
                <button x-on:click="inputType = (inputType=== 'password') ? 'text' : 'password' "
                    class="text-dark text-sm absolute top-9 right-2" type="button"
                    x-text="inputType === 'password' ? 'Show' : 'Hide'"></button>
            </div>
            <input x-bind:disabled="isSubmitting" type="submit"
                class="mt-5 bg-main disabled:bg-pale disabled:text-dark p-2 w-full rounded-md" value="Mendaftar">
            <p class="text-sm">Sudah punya akun? <a class="text-main" href="/login">Masuk</a></p>
        </form>
    </div>
@endsection
