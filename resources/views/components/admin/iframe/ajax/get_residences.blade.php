<script>
    function getResidences() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{ route('admin.residences.get') }}',
            type: 'POST',
            data: {'city_id': $('#city').val()},
            dataType: 'json',
            success: function (response) {
                const residence_select = $('#residence');
                residence_select.empty().append('<option selected disabled class="hidden" value="">Select One</option>');
                response.forEach(residence => {
                    residence_select.append(`<option value="${residence.id}">${residence.name}</option>`);
                });
            },
        });
    }
</script>
