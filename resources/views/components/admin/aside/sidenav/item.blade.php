@props(['name', 'href', 'isActive', 'click' => null])
@php
    $active_class = 'hover:bg-blue-500 hover:text-white';
    if ($isActive){
        $active_class = 'bg-blue-500 text-white';
    }
@endphp
<li class="rounded {{ $active_class }} transition-colors duration-150 cursor-pointer" @click="{{ $click }}">
    <a href="{{ $href }}" class="block w-full p-2">{{ $name }}</a>
</li>
