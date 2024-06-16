@props(['name', 'text', 'value'])
<div class="flex flex-col">
    <label for="{{ $name }}" class="block mb-2 text-sm font-medium">{{ $text }}</label>
    <select id="{{ $name }}" name="{{ $name }}"
        class="bg-pale text-dark text-sm rounded-lg w-full border-none focus:ring-main" id="position" required>
        <option selected value="" disabled>Pilih Teknisi</option>
        @foreach ($employees as $employee)
            <option {{ AppHelper::unObfuscate($value ?? null) == $employee->id ? 'selected' : '' }}
                value="{{ AppHelper::obfuscate($employee->id) }}">
                {{ $employee->name }}</option>
        @endforeach
    </select>
</div>
