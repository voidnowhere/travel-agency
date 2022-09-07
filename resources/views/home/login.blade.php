<x-home.layout>
    <div class="flex justify-center px-3 sm:px-0">
        <form method="post" class="mt-20 px-5 pt-5 pb-2 shadow-lg rounded-lg bg-blue-100">
            @csrf
            <x-form.input_text name="email" type="email" label="Email"/>
            <x-form.input_text name="password" type="password" label="Password"/>
            <x-form.recaptcha/>
            <div class="text-center mt-2">
                <a href="{{ route('password.request') }}" class="underline text-gray-600 hover:text-gray-900">
                    Forgot your password?
                </a>
            </div>
            <x-form.submit>Login</x-form.submit>
        </form>
    </div>
</x-home.layout>
