<x-home.layout>
    <div class="flex justify-center items-center grow sm:grow-0">
        <form method="post" class="px-0 sm:px-5 pt-4 sm:pt-5 pb-2 shadow-lg rounded-lg bg-blue-100">
            @csrf
            <x-form.input_text name="password" type="password" label="Password"/>
            <x-form.input_text name="new_password" type="password" label="New password" :return-old="false"/>
            <x-form.input_text name="new_password_confirmation" type="password" label="Confirm" :return-old="false"/>
            <x-form.submit>Change</x-form.submit>
        </form>
    </div>
</x-home.layout>
