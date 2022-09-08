<x-home.layout>
    <div class="flex justify-center flex-col items-center">
        <div class="w-full md:w-2/3 lg:w-1/2 px-5 pt-5 sm:pt-0 pb-10">
            <p>Forgot your password? No problem. Just let us know your email address and we will email you a password
                reset link that will allow you to choose a new one.</p>
        </div>
        <form method="POST" id="forgot_password_form" action="{{ route('password.email') }}"
              class="px-5 pt-5 pb-2 shadow-lg rounded-lg bg-blue-100 flex flex-col">
            @csrf
            <x-form.input_text name="email" label="Email" type="email"/>
            <x-form.recaptcha_invisible label="Email Password Reset Link" form-id="forgot_password_form"/>
        </form>
    </div>
</x-home.layout>
