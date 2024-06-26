@extends('layouts.worker.layout')
@section('content')
    <div>
        <div class="p-4 border text-center rounded-b-md border-mWhite shadow-md font-semibold">Profile</div>
        <div class="flex w-full flex-col gap-4 p-4 rounded-md">
            <form x-data="{ isSubmitting: false }" x-on:submit.prevent="isSubmitting = true; $el.submit()" method="post" action=""
                class="w-full gap-4 flex flex-col shadow-md bg-white rounded-md p-4 border border-main">
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
                    <label for="bank_name" class="block mb-2 text-sm font-medium">Nama Bank</label>
                    <input type="bank_name" id="bank_name" name="bank_name" value="{{ $employee->bank_name }}"
                        class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                        placeholder="BCA" required />
                </div>
                <div class="w-full">
                    <label for="bank_number" class="block mb-2 text-sm font-medium">Nomor Bank</label>
                    <input type="bank_number" id="bank_number" name="bank_number" value="{{ $employee->bank_number }}"
                        class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                        placeholder="0101020203030" required />
                </div>
                <div class="w-full">
                    <label for="position" class="block mb-2 text-sm font-medium">Jabatan</label>
                    <select name="position" class="bg-pale text-dark text-sm rounded-lg w-full border-none focus:ring-main"
                        id="position" required>
                        <option selected value="" disabled>Pilih Jabatan</option>
                        @foreach ($positions as $position)
                            <option {{ $employee->position_id == $position->id ? 'selected' : '' }}
                                value="{{ $position->id }}">
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
                            <option {{ $employee->location_id == $location->id ? 'selected' : '' }}
                                value="{{ $location->id }}">
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
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <input x-bind:disabled="isSubmitting" type="submit"
                        class="cursor-pointer border border-main shadow-md hover:bg-main hover:text-white text-main disabled:bg-pale disabled:text-dark p-2  rounded-md"
                        value="Simpan">
                    <a href="{{ route('worker.logout') }}"
                        class="border border-danger p-2 text-danger hover:bg-danger hover:text-white text-center rounded-md">Logout</a>
                </div>


            </form>

        </div>
    </div>
@endsection
