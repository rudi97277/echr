@extends('layouts.admin.layout')
@section('content')
    <div class="w-full h-full overflow-y-auto p-2">
        <div class="grid  sm:grid-cols-2 gap-6">
            <form action="" method="post" class="gap-4 flex flex-col  border p-2 border-main shadow-md rounded-md"
                x-data="{ isSubmitting: false }" x-on:submit.prevent="isSubmitting = true; $el.submit()">
                @method('put')
                <h1 class="font-semibold text-lg mb-2">Edit Data Karyawan</h1>
                @csrf
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
                    <label for="bank_name" class="block mb-2 text-sm font-medium">Nama Bank</label>
                    <input type="bank_name" id="bank_name" name="bank_name" value="{{ $employee->bank_name }}"
                        autocomplete="off" disabled
                        class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                        placeholder="BCA" required />
                </div>
                <div class="w-full">
                    <label for="bank_number" class="block mb-2 text-sm font-medium">Nomor Bank</label>
                    <input type="bank_number" id="bank_number" name="bank_number" value="{{ $employee->bank_number }}"
                        autocomplete="off" disabled
                        class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                        placeholder="0101020230030.com" required />
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

                <div class="w-full">
                    <label for="role" class="block mb-2 text-sm font-medium">Role</label>
                    <select name="role"
                        class="bg-gray-50 text-dark text-sm rounded-lg w-full border-none focus:ring-main" id="role"
                        required>
                        <option selected value="" disabled>Pilih Role</option>
                        <option value="">Tanpa Role</option>
                        @foreach ($roles as $role)
                            <option {{ $employee->role == $role ? 'selected' : '' }} value="{{ $role }}">
                                {{ ucwords(str_replace('_', ' ', $role)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full grid grid-cols-2 items-center gap-2">
                    <input x-bind:disabled="isSubmitting" type="submit"
                        class=" bg-main disabled:bg-pale cursor-pointer text-white disabled:text-dark p-1  rounded-md"
                        value="Simpan">
                    <a href="{{ route('admin.master-karyawan') }}"
                        class="bg-danger text-center p-1 rounded-md text-white">Batal</a>
                </div>
            </form>

            <div class="gap-2 flex flex-col w-full">
                <h1 class="font-semibold text-lg mb-2">Gaji Karyawan</h1>
                <form method="post" action="" class="mb-2">
                    @method('put')
                    @csrf
                    <div class="w-full grid gap-2">
                        <select name="add_salary"
                            class=" bg-gray-50 text-dark text-sm rounded-lg border-none focus:ring-main" required>
                            <option selected value="" disabled>Pilih Jenis Gaji</option>
                            @foreach ($listSalary as $salary)
                                <option value="{{ $salary->code }}">
                                    {{ $salary->name }}</option>
                            @endforeach
                        </select>
                        <x-currency class=" border-none w-full  bg-gray-50 rounded-md text-sm" name="amount"
                            required="required" />
                        <input type="submit" class="bg-complement text-white rounded-md p-2 text-sm" value="Simpan">
                    </div>
                </form>
                <div class="flex-col grid grid-cols-3 text-sm font-bold border rounded-md shadow-md">
                    <p class="bg-pale p-2">NAMA</p>
                    <p class="bg-pale p-2">JUMLAH</p>
                    <p class="bg-pale p-2">ACTION</p>
                    @foreach ($salaries as $salary)
                        <p class="font-normal px-2 py-1 my-2">{{ $salary->name }}</p>
                        <p class="font-normal px-2 py-1 my-2">{!! AppHelper::formatRupiah($salary->amount) !!}</p>
                        <form method="post" action="" class="my-2">
                            @method('put')
                            @csrf
                            <input type="hidden" name="delete_salary" value="{{ $salary->id }}">
                            <input type="submit" value="Hapus"
                                class="cursor-pointer bg-danger p-1 rounded-md text-white">
                        </form>
                    @endforeach

                </div>
            </div>
        </div>

    </div>
@endsection
