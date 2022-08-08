<x-admin.iframe.layout title="Edit Residence" :load-jquery="true">
    <x-form.container
        title="Residence"
        :iframe-id-to-close="\App\Iframes\ResidenceIframe::$iframeCUId">
        <x-form.layout :patch="true">
            <div class="grid grid-cols-2">
                <div class="mt-2">
                    <x-form.input_text name="name" type="text" label="Name" :value="$residence->name"/>
                </div>
                <x-residence-categories-select :value="$residence->category->id"/>
            </div>
            <div class="grid grid-cols-2">
                <x-country-select on-change="getCities()" :value="$residence->city->country_id"/>
                <x-cities-select :country="$residence->city->country" :value="$residence->city_id"/>
            </div>
            <div class="grid grid-cols-2">
                <x-form.input_text name="website" type="text" label="Website" :value="$residence->website"/>
                <x-form.input_text name="email" type="email" label="Email" :value="$residence->email"/>
            </div>
            <div class="grid grid-cols-2">
                <x-form.input_text name="contact" type="text" label="Contact" :value="$residence->contact"/>
                <x-form.input_text name="order" type="text" label="Order" :value="$residence->order_by"/>
            </div>
            <div class="grid grid-cols-2">
                <x-form.input_text name="tax" type="text" label="Tax" :value="$residence->tax"/>
                <x-form.input_check
                    name="active" type="checkbox"
                    :required="false" label="Active"
                    :value="$residence->is_active"/>
            </div>
            <x-form.textarea name="description" label="Description" :value="$residence->description"/>
            <x-form.submit>Edit</x-form.submit>
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
