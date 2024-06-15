@props(['class', 'name'])
<div x-data="{
    formatted: '',
    amount: 0,
    formatCurrency: function() {
        this.amount = this.formatted.replace(/\D/g, '');
        this.formatted = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(this.amount);
    }
}">
    <input type="text" x-model="formatted" x-on:input="formatCurrency" class="{{ $class ?? '' }}" placeholder="Jumlah"
        required />
    <input type="hidden" name="{{ $name ?? '' }}" x-model="amount">
</div>
