@props(['onClick' => null])
<div class="p-2 text-right">
    <button
        type="submit"
        onclick="{{ $onClick }}"
        class="px-4 py-1 rounded-full bg-blue-400 hover:bg-blue-500 hover:text-white transition-colors duration-150"
    >{{ $slot }}</button>
</div>
