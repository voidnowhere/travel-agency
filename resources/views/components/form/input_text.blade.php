@props(['label', 'name', 'type', 'value' => null, 'required' => true, 'returnOld' => true])
<div class="p-2">
    <div class="flex">
        <x-form.label :label="$label"/>
        <input type="{{ $type }}"
               name="{{ $name }}"
               @required($required)
               value="{{ ($returnOld && $name !== 'password' && $name !== 'password_confirmation') ? old($name, $value) : null }}"
               class="p-1 bg-gray-100 rounded-lg focus:bg-white w-full">
    </div>
    <x-form.input_error :name="$name"/>
</div>
