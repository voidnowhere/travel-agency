<x-home.layout>
    <div class="flex justify-center flex-col items-center">
        <div class="w-full md:w-2/3 lg:w-1/2 px-5 pt-5 sm:pt-0 pb-10">
            <p>
                Thanks for signing up! Before getting started, could you verify your email address by clicking on the
                link we just emailed to you? If you didn't receive the email, we will gladly send you another.
            </p>
        </div>
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-form.submit>Resend Verification Email</x-form.submit>
        </form>
    </div>
</x-home.layout>
