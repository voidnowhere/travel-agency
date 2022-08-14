<x-home.layout>
    <div class="flex justify-center">
        <form method="post" class="mt-20 px-5 pt-5 pb-2 shadow-lg rounded-lg bg-blue-100">
            @csrf
            <x-form.input_text name="name" type="text" label="Name"/>
            <x-form.input_text name="email" type="email" label="Email"/>
            <x-form.input_text name="password" type="password" label="Password"/>
            <x-form.input_text name="password_confirmation" type="password" label="Confirm"/>
            <x-form.submit>Register</x-form.submit>
        </form>
    </div>
</x-home.layout>
