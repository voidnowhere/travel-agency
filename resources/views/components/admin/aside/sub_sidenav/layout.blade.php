@props(['xShow'])
<ul class="mx-2 space-y-1 text-sm" x-show="{{ $xShow }}">
    {{ $slot }}
</ul>
