@props(['id', 'widthClass', 'heightClass'])
<iframe id="{{ $id }}"
        class="{{ $widthClass }} {{ $heightClass }} absolute hidden top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></iframe>
