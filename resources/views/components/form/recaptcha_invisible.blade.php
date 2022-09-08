@props(['label', 'formId'])
<div class="flex flex-col items-center mt-3 mb-2">
    <x-form.input_error name="g-recaptcha-response"/>
    {!! NoCaptcha::renderJs() !!}
    {!! NoCaptcha::displaySubmit($formId, $label, ['class' => 'px-4 py-1 rounded-full bg-blue-400 hover:bg-blue-500 hover:text-white transition-colors duration-150']) !!}
</div>
