@props(['name'])
@error($name)
<p class="text-red-500 text-sm text-center mt-2">{{ $message }}</p>
@enderror
