@props(['label', 'name', 'value' => null, 'required' => true])
<div class="p-2">
    <div class="flex items-center">
        <x-form.label :label="$label"/>
        <textarea name="{{ $name }}"
                  {{ ($required) ? 'required': '' }}
                  rows="4" cols="69"
                  class="p-1 ml-1 bg-gray-100 rounded-lg focus:bg-white">{{ old($name) ?? $value }}</textarea>
    </div>
    <x-form.input_error :name="$name"/>
</div>
