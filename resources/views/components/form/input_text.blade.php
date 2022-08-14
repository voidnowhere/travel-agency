@props(['label', 'name', 'type', 'value' => null, 'required' => true])
<div class="p-2">
    <x-form.label :label="$label"/>
    <input type="{{ $type }}"
           name="{{ $name }}"
           @required($required)
           value="{{ ($name !== 'password' && $name !== 'password_confirmation') ? old($name) ?? $value : null }}"
           class="p-1 bg-gray-100 rounded-lg focus:bg-white">
    <x-form.input_error :name="$name"/>
</div>
