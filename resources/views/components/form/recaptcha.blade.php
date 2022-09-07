<div class="flex flex-col items-center mt-2">
    {!! NoCaptcha::renderJs() !!}
    {!! NoCaptcha::display() !!}
    <x-form.input_error name="g-recaptcha-response"/>
</div>
