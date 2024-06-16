@extends('layouts.admin.layout')
@section('content')
    <div class="w-full h-full">
        <form action="" class="flex gap-2 mb-4">
            <div>
                <select name="target" class="bg-pale text-dark text-sm rounded-lg w-full border-none focus:ring-main"
                    required>
                    <option selected value="" disabled>Pilih Payroll</option>
                    @foreach ($payrolls as $payroll)
                        <option {{ $target == $payroll->id ? 'selected' : '' }}
                            value="{{ AppHelper::obfuscate($payroll->id) }}">
                            {{ $payroll->name }}</option>
                    @endforeach
                </select>
            </div>
            <input type="submit" class="bg-main rounded-md p-2 text-sm text-white" value="Cari">

            <button data-modal-target="add-payroll" data-modal-toggle="add-payroll"
                class="text-white bg-complement text-sm rounded-md p-1 ms-auto" type="button">
                Tambah
            </button>
        </form>


        <div id="add-payroll" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow ">
                    <form action="" method="POST" class="p-4">
                        @csrf
                        <h1 class="font-semibold text-lg mb-2">Tambah Payroll</h1>
                        <div class="w-full mb-2">
                            <label for="name" class="block mb-2 text-sm font-medium">Nama</label>
                            <input type="text" id="name" name="name"
                                class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                                placeholder="Nama payroll" required />
                        </div>
                        <div class="w-full">
                            <label for="date" class="block mb-2 text-sm font-medium">Tanggal</label>
                            <input type="text" id="date" name="date" datepicker datepicker-autohide
                                datepicker-format="dd/mm/yy"
                                class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                                placeholder="Tanggal akhir payroll" required />
                        </div>
                        <input type="submit" value="Simpan"
                            class="rounded-md p-2 bg-main text-sm text-white mt-4 cursor-pointer">
                    </form>
                </div>
            </div>
        </div>

        <x-custom-table :$headers :source="$payslips" :$pagination disableSearch="true">
            <x-slot:action>
                <div class="flex gap-1 text-xs">
                    <a class="rounded-md bg-complement text-white p-1 gap-1 flex items-center"
                        href="{{ route('admin.payslip.detail', '#target_id') }}">
                        <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2"
                                d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        Lihat</a>
                </div>
            </x-slot:action>
        </x-custom-table>
    </div>
@endsection
