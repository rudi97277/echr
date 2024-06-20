@extends('layouts.admin.layout')
@section('content')
    <div class="w-full h-full flex flex-col overflow-y-scroll">
        <x-month-picker />
        <x-custom-table :$headers :source="$attendances" :$pagination disableSearch="true">
            @scopedslot('action', $item)
                @if (collect($item)['id_amount'] > 0)
                    <div class="flex gap-1 text-sm">
                        <a href="{{ route('admin.penalty.correction', AppHelper::obfuscate($item['id'])) }}"
                            class="flex items-center bg-danger text-white rounded-md p-1 gap-1">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z"
                                    clip-rule="evenodd" />
                            </svg>
                            Koreksi
                        </a>
                    </div>
                @endif
            @endscopedslot
        </x-custom-table>
    </div>
@endsection
