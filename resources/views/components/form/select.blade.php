@props([
    'label', 'name', 'default' => true,
    'values' => array(), 'value' => null, 'returnOld' => true,
    'required' => true, 'onChange' => null
])
<div class="p-2">
    <x-form.label :label="$label"/>
    <select id="{{ $name }}" name="{{ $name }}" {{ ($required) ? 'required': '' }} onchange="{{ $onChange }}"
            class="p-2 bg-gray-100 rounded-lg border-2 border-blue-400 ring-blue-500 w-[189px]">
        @if($default)
            <option selected disabled class="hidden" value="">Select One</option>
        @endif
        @foreach($values as $val)
            <option
                value="{{ $val->id }}" {{ ($returnOld && (old($name) ?? $value) == $val->id) ? 'selected' : '' }}>{{ $val->name }}</option>
        @endforeach
    </select>
    <x-form.input_error :name="$name"/>
</div>
