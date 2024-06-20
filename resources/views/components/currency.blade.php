@props(['class', 'name', 'required', 'placeholder', 'value'])
<div class="w-full" x-data="{
    formatted: @js($value ?? null ? AppHelper::formatRupiah($value, false) : 'Rp 0'),
    amount: @js($value ?? 0),
    formatCurrency: function() {
        const isNegative = (this.formatted.match(/-/g) || []).length == 1;
        this.amount = this.formatted.replace(/\D/g, '');
        this.amount = this.amount * (isNegative ? -1 : 1);
        this.formatted = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(this.amount);
    }
}">
    <input type="text" x-model="formatted" x-on:input="formatCurrency" class="{{ $class ?? '' }}"
        placeholder="{{ $placeholder ?? 'Jumlah' }}" {{ $required ?? '' }} />
    <input type="hidden" name="{{ $name ?? '' }}" x-model="amount">

</div>
