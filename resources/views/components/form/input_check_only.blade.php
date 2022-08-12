@props(['name', 'type', 'value' => null, 'required' => true])
<input type="{{ $type }}"
       name="{{ $name }}"
       @required($required)
       @checked(old($name) ?? $value)
       class="p-1 hover:cursor-pointer w-4 h-4">
