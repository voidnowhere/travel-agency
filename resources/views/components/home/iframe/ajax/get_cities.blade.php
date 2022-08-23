<script>
    function getCities() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{ route('cities.get') }}',
            type: 'POST',
            data: {'country_id': $('#country').val()},
            dataType: 'json',
            success: function (response) {
                const city_select = $('#city');
                if (response.length !== 0) {
                    city_select.empty().append('<option selected disabled class="hidden" value="">Select One</option>');
                    response.forEach(city => {
                        city_select.append(`<option value="${city.id}">${city.name}</option>`);
                    });
                }
            },
        });
    }
</script>
