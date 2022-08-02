@props(['name', 'href', 'isActive' => request()->url() == $href])
@php
    $active_class = 'hover:bg-blue-500 hover:text-white';
    if ($isActive){
        $active_class = 'bg-blue-500 text-white';
    }
@endphp
<li class="p-2 rounded {{ $active_class }} transition-all duration-150 cursor-pointer">
    <a href="{{ $href }}" class="block w-full">{{ $name }}</a>
</li>
