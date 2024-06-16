@props(['name', 'text', 'value'])
<div class="flex flex-col">
    <label for="{{ $name }}" class="block mb-2 text-sm font-medium">{{ $text }}</label>
    <select id="{{ $name }}" name="{{ $name }}"
        class="bg-pale text-dark text-sm rounded-lg w-full border-none focus:ring-main" id="position" required>
        <option selected value="" disabled>Pilih Paket</option>
        @foreach ($packages as $package)
            <option {{ ($value ?? '') == $package['value'] ? 'selected' : '' }} value="{{ $package['value'] }}">
                {{ $package['name'] }}</option>
        @endforeach
    </select>
</div>
