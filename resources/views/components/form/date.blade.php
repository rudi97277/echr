@props(['name', 'text', 'value'])
<div class="flex flex-col">
    <label for="{{ $name }}" class="block mb-2 text-sm font-medium">{{ $text }}</label>
    <input datepicker datepicker-autohide type="text" id="{{ $name }}" name="{{ $name }}"
        datepicker-format="dd/mm/yy"
        class="bg-pale text-dark text-sm rounded-lg border-none focus:ring-main block w-full p-2.5 "
        placeholder="Pilih tanggal" required value="{{ $value ?? '' }}" />
</div>
