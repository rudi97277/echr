<form action="" class="flex gap-2 mb-4">
    <div>
        <select name="month" class="bg-pale text-dark text-sm rounded-lg w-full border-none focus:ring-main"
            value="{{ request()->month }}" required>
            <option selected value="" disabled>Pilih Bulan</option>
            @foreach ($months as $month)
                <option {{ (request()->month ?? date('m')) == $month['value'] ? 'selected' : '' }}
                    value="{{ $month['value'] }}">
                    {{ $month['name'] }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <select name="year" class="bg-pale text-dark text-sm rounded-lg w-full border-none focus:ring-main" required>
            <option selected value="" disabled>Pilih Tahun</option>
            @foreach ($years as $year)
                <option {{ (request()->year ?? date('Y')) == $year ? 'selected' : '' }}>
                    {{ $year }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <input type="submit" value="Cari" class="rounded-md bg-main text-white p-2 text-sm">
    </div>
</form>
