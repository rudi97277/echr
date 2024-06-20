@extends('layouts.admin.layout')

@section('content')
    <div class="w-full h-full grid sm:grid-cols-2 overflow-y-scroll">
        <form action="" method="post" class="gap-4 flex flex-col" x-data="{ isSubmitting: false }"
            x-on:submit.prevent="isSubmitting = true; $el.submit()">
            @method('put')
            @csrf
            <h1 class="font-semibold text-lg mb-2">Edit Data Lokasi</h1>
            <div class="w-full mb-2">
                <label for="name" class="block mb-2 text-sm font-medium">Nama</label>
                <input type="text" id="name" name="name"
                    class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                    placeholder="Nama lokasi" value="{{ $location->name }}" required />
            </div>
            <div class="w-full mb-2">
                <label for="address" class="block mb-2 text-sm font-medium">Alamat</label>
                <input type="text" id="address" name="address"
                    class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
                    placeholder="Alamat lengkap" value="{{ $location->address }}" required />
            </div>

            <div class="w-full grid grid-cols-2 items-center gap-2">
                <input x-bind:disabled="isSubmitting" type="submit"
                    class=" bg-main disabled:bg-pale cursor-pointer text-white disabled:text-dark p-1  rounded-md"
                    value="Simpan">
                <a href="{{ route('admin.master-lokasi') }}"
                    class="bg-danger text-center p-1 rounded-md text-white">Batal</a>
            </div>
        </form>
    </div>
@endsection
