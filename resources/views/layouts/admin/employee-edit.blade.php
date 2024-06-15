@extends('layouts.admin.layout')
@section('content')
    <div class="w-full h-full p-2">
        <div class="grid  sm:grid-cols-2 gap-6">
            <form action="" method="post" class="gap-4 flex flex-col" x-data="{ isSubmitting: false }"
                x-on:submit.prevent="isSubmitting = true; $el.submit()">
                @csrf
                <h1 class="font-semibold text-lg mb-2">Edit Data Karyawan</h1>
                <div class="w-full">
                    <label for="name" class="block mb-2 text-sm font-medium">Nama</label>
                    <input type="text" id="name" name="name" value="{{ $employee->name }}"
                        class="bg-gray-50 text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                        placeholder="John Doe" required />
                </div>
                <div class="w-full">
                    <label for="email" class="block mb-2 text-sm font-medium">Email</label>
                    <input type="email" id="email" name="email" value="{{ $employee->email }}" autocomplete="off"
                        disabled
                        class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                        placeholder="email@gmail.com" required />
                </div>
                <div class="w-full">
                    <label for="position" class="block mb-2 text-sm font-medium">Jabatan</label>
                    <select name="position"
                        class="bg-gray-50 text-dark text-sm rounded-lg w-full border-none focus:ring-main" id="position"
                        required>
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
                    <select name="shift"
                        class="bg-gray-50 text-dark text-sm rounded-lg w-full border-none focus:ring-main" id="shift"
                        required>
                        <option selected value="" disabled>Pilih Jam Kerja</option>
                        @foreach ($shifts as $shift)
                            <option {{ $employee->shift_id == $shift->id ? 'selected' : '' }} value="{{ $shift->id }}">
                                {{ $shift->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full">
                    <label for="location" class="block mb-2 text-sm font-medium">Lokasi Kerja</label>
                    <select name="location"
                        class="bg-gray-50 text-dark text-sm rounded-lg w-full border-none focus:ring-main" id="location"
                        required>
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
                        class="bg-gray-50 text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                        placeholder="*******" autocomplete="new-password" />
                    <button x-on:click="inputType = (inputType=== 'password') ? 'text' : 'password' "
                        class="text-dark text-sm absolute top-9 right-2" type="button"
                        x-text="inputType === 'password' ? 'Show' : 'Hide'"></button>
                </div>
                <div class="w-full grid grid-cols-2 items-center gap-2">
                    <input x-bind:disabled="isSubmitting" type="submit"
                        class=" bg-main disabled:bg-pale cursor-pointer text-white disabled:text-dark p-1  rounded-md"
                        value="Simpan">
                    <a href="{{ route('admin.karyawan') }}"
                        class="bg-danger text-center p-1 rounded-md text-white">Batal</a>
                </div>
            </form>

            <div action="" class="gap-2 flex flex-col">
                <h1 class="font-semibold text-lg mb-2">Gaji Karyawan</h1>
                <form method="post" action="" class="mb-2">
                    @csrf
                    <div class="w-full flex gap-2">
                        <select name="add_salary"
                            class="bg-gray-50 text-dark text-sm rounded-lg w-full border-none focus:ring-main" required>
                            <option selected value="" disabled>Pilih Jenis Gaji</option>
                            @foreach ($listSalary as $salary)
                                <option value="{{ $salary->code }}">
                                    {{ $salary->name }}</option>
                            @endforeach
                        </select>
                        <x-currency class="border-none bg-gray-50 rounded-md text-sm" name="amount" />
                        <input type="submit" class="bg-complement text-white rounded-md p-1 text-sm" value="Tambah">
                    </div>
                </form>
                <div class="flex gap-2">
                    <x-custom-table :headers="['Nama', 'Jumlah']" :source="$salaries" :pagination="$pagination ?? []" disableSearch="true">
                        <x-slot:action>
                            <div>
                                <form method="post" action="">
                                    @csrf
                                    <input type="hidden" name="delete_salary" value="#target_id">
                                    <input type="submit" value="Hapus"
                                        class="cursor-pointer bg-danger p-1 rounded-md text-white">
                                </form>
                            </div>
                        </x-slot:action>

                    </x-custom-table>
                </div>
            </div>
        </div>

    </div>
@endsection
