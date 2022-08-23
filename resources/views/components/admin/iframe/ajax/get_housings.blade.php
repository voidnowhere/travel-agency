<script>
    function getHousings() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{ route('admin.housings.get') }}',
            type: 'POST',
            data: {'residence_id': $('#residence').val()},
            dataType: 'json',
            success: function (response) {
                const housing_select = $('#housing');
                if (response.length > 0) {
                    housing_select.empty().append('<option selected disabled class="hidden" value="">Select One</option>');
                    response.forEach(housing => {
                        housing_select.append(`<option value="${housing.id}">${housing.name}</option>`);
                    });
                }
            },
        });
    }
</script>
