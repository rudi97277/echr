@props(['name', 'text', 'value'])
<div class="flex flex-col">
    <label for="{{ $name }}" class="block mb-2 text-sm font-medium">{{ $text }}</label>
    <input type="text" id="{{ $name }}" name="{{ $name }}"
        class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
        placeholder="Masukkan lokasi" required value="{{ $value ?? '' }}" />
</div>
