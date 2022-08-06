@props(['patch' => false, 'delete' => false])
<form method="post">
    @csrf
    @if($patch)
        @method('PATCH')
    @endif
    @if($delete)
        @method('DELETE')
    @endif
    {{ $slot }}
</form>
