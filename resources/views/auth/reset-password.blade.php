<x-home.layout :load-jquery="true">
    <div class="flex justify-center flex-col items-center">
        <form method="post" action="{{ route('password.update') }}"
              class="px-0 sm:px-5 pt-4 sm:pt-5 pb-2 shadow-lg rounded-lg bg-blue-100">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <x-form.input_text name="email" type="email" label="Email"/>
            <x-form.input_text name="password" type="password" label="Password"/>
            <x-form.input_text name="password_confirmation" type="password" label="Confirm"/>
            <x-form.submit>Reset Password</x-form.submit>
        </form>
    </div>
</x-home.layout>
