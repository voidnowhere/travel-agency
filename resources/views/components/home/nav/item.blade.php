@props(['name', 'href', 'isActive' => false])
<li @class(['rounded transition-colors duration-150 cursor-pointer hover:bg-blue-500 hover:text-white',
            'bg-blue-500 text-white' => $isActive])>
    <a href="{{ $href }}" class="block w-full px-3 py-1">{{ $name }}</a>
</li>
