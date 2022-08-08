<x-admin.iframe.layout title="Add Residence" :load-jquery="true">
    <x-form.container
        title="Residence"
        :iframe-id-to-close="\App\Iframes\ResidenceIframe::$iframeCUId">
        <x-form.layout>
            <div class="grid grid-cols-2">
                <div class="mt-2">
                    <x-form.input_text name="name" type="text" label="Name"/>
                </div>
                <x-residence-categories-select/>
            </div>
            <div class="grid grid-cols-2">
                <x-country-select on-change="getCities()" :return-old="false"/>
                <x-form.select name="city" label="City" :default="false" :return-old="false"/>
            </div>
            <div class="grid grid-cols-2">
                <x-form.input_text name="website" type="text" label="Website"/>
                <x-form.input_text name="email" type="email" label="Email"/>
            </div>
            <div class="grid grid-cols-2">
                <x-form.input_text name="contact" type="text" label="Contact"/>
                <x-form.input_text name="order" type="text" label="Order"/>
            </div>
            <div class="grid grid-cols-2">
                <x-form.input_text name="tax" type="text" label="Tax"/>
                <x-form.input_check name="active" type="checkbox" :required="false" label="Active"/>
            </div>
            <x-form.textarea name="description" label="Description"/>
            <x-form.submit>Create</x-form.submit>
        </x-form.layout>
    </x-form.container>
    <script>
        function getCities() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route('admin.cities.get') }}',
                type: 'POST',
                data: {'country_id': $('#country').val()},
                dataType: 'json',
                success: function (response) {
                    const city_select = $('#city');
                    city_select.empty().append('<option selected disabled class="hidden" value="">Select One</option>');
                    response.forEach(city => {
                        city_select.append(`<option value="${city.id}">${city.name}</option>`);
                    });
                },
            });
        }
    </script>
</x-admin.iframe.layout>
