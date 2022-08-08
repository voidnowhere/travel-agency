@props(['label', 'name', 'type', 'value' => null, 'required' => true])
<div class="p-2">
    <x-form.label :label="$label"/>
    <input type="{{ $type }}"
           name="{{ $name }}"
           {{ ($required) ? 'required': '' }}
           {{ (old($name) ?? $value) ? 'checked' : '' }}
           class="p-1 hover:cursor-pointer w-4 h-4">
    <x-form.input_error :name="$name"/>
</div>
