@props(['count'])
<tbody>
@if($count > 0)
    {{ $slot }}
@else
    <tr>
        <td colspan="3" class="text-center">No Data Found!</td>
    </tr>
@endif
</tbody>
