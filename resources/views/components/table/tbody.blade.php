@props(['count', 'columnsCount'])
<tbody>
@if($count > 0)
    {{ $slot }}
@else
    <tr>
        <td colspan="{{ $columnsCount + 1 }}" class="text-center">No Data Found!</td>
    </tr>
@endif
</tbody>
