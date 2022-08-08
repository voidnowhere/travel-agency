@props(['name', 'href'])
@php
    $active_class = 'hover:text-white hover:bg-blue-500';
    if (request()->url() === $href){
        $active_class = 'bg-blue-500 text-white';
    }
@endphp
<li class="p-1 pl-3 flex items-center rounded {{ $active_class }} transition-colors duration-150">
    <span class="bg-blue-500 mr-2 w-2 h-2 inline-block rounded-full"></span>
    <a href="{{ $href }}" class="inline-block w-full">{{ $name }}</a>
</li>
