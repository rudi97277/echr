@extends('layouts.worker.layout')
@section('content')
    <div class=" flex w-full flex-col gap-4 p-4 rounded-md ">
        <div class="rounded-md text-center w-full bg-white py-4">
            <h1 class="text-xl font-bold m-0">Masuk</h1>
            <p>Isi email dan kata sandi untuk masuk</p>
        </div>
        <form x-data="{ isSubmitting: false }" x-on:submit.prevent="isSubmitting = true; $el.submit()" method="post" action=""
            class="w-full gap-4 flex flex-col shadow-md bg-dark text-white rounded-md p-4">
            @csrf
            <div class="w-full">
                <label for="email" class="block mb-2 text-sm font-medium  ">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main active:border-none block w-full p-2.5 "
                    placeholder="email@gmail.com" required />
            </div>
            <div class="w-full relative" x-data="{ inputType: 'password' }">
                <label for="password" class="block mb-2 text-sm font-medium  ">Kata sandi</label>
                <input :type="inputType" id="password" name="password"
                    class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main active:border-none block w-full p-2.5 "
                    placeholder="*******" required />
                <button x-on:click="inputType = (inputType=== 'password') ? 'text' : 'password' "
                    class="text-dark text-sm absolute top-9 right-2" type="button"
                    x-text="inputType === 'password' ? 'Show' : 'Hide'"></button>
            </div>
            <input type="submit" x-bind:disabled="isSubmitting"
                class="mt-5 bg-main p-2 w-full rounded-md disabled:bg-pale disabled:text-dark" value="Masuk">
            <p class="text-sm">Belum punya akun? <a class="text-main" href="/register">Mendaftar</a></p>
        </form>
    </div>
@endsection
