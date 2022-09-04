@props([
    'label', 'name', 'default' => true,
    'values' => array(), 'value' => null, 'returnOld' => true,
    'required' => true, 'onChange' => null, 'areValuesArray' => false,
])
<div class="p-2">
    <div class="flex items-center">
        <x-form.label :label="$label"/>
        <select id="{{ $name }}" name="{{ $name }}" @required($required) onchange="{{ $onChange }}"
                class="p-2 bg-gray-100 rounded-lg border-2 border-blue-400 ring-blue-500 grow max-w-[210px]">
            @if($default)
                <option selected disabled class="hidden" value="">Select One</option>
            @endif
            @foreach($values as $val)
                @if($areValuesArray)
                    <option
                        value="{{ $val }}" @selected($returnOld && (old($name) ?? $value) == $val)>{{ ucfirst($val) }}</option>
                @else
                    <option
                        value="{{ $val->id }}" @selected($returnOld && (old($name) ?? $value) == $val->id)>{{ $val->name }}</option>
                @endif
            @endforeach
        </select>
    </div>
    <x-form.input_error :name="$name"/>
</div>
