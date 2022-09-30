@php
    $columns = ['Name', 'Email', 'Phone number', 'Address', 'Active'];
@endphp
<x-admin.iframe.layout title="Clients" :load-jquery="true" :load-notiflix="true">
    <x-table.layout>
        <x-table.thead :columns="$columns" :iframe-c-u-id="\App\Iframes\UserIframe::$iframeCUId"
                       :route-create="route('admin.users.create')"/>
        <x-table.tbody :count="$users->count()" :columns-count="count($columns)">
            @foreach($users as $user)
                <tr @class(['border-b-2 border-b-blue-400', 'bg-blue-50' => $loop->even])>
                    <td class="py-3 px-6">{{ $user->full_name }}</td>
                    <td class="text-center py-3 px-6">
                        <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                    </td>
                    <td class="text-center py-3 px-6">{{ $user->phone_number }}</td>
                    <td class="text-center py-3 px-6">{{ $user->full_address }}</td>
                    <td class="text-center py-3 px-6">
                        <input type="checkbox" id="is_active" class="w-4 h-4 hover:cursor-pointer"
                               @checked($user->is_active) onclick="setUserIsActive({{ $user->id }}, this)">
                    </td>
                    <td class="flex justify-center p-3 mr-2">
                        <x-svg.crud.edit
                            :iframe-c-u-id="\App\Iframes\UserIframe::$iframeCUId"
                            :route-u="route('admin.users.user.edit', ['user' => $user->id])"/>
                    </td>
                </tr>
            @endforeach
        </x-table.tbody>
    </x-table.layout>
    <div class="mt-1">
        {{ $users->onEachSide(1)->links() }}
    </div>
    <x-admin.iframe.js.show_cu_iframe/>
    <x-admin.iframe.ajax.set_user_is_active/>
</x-admin.iframe.layout>
