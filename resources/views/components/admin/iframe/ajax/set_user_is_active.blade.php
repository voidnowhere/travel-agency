<script>
    function setUserIsActive(id, checkbox) {
        let checked = checkbox.checked;
        Confirm.show(
            'Confirmation',
            'Do you want to ' + ((checked) ? 'activate' : 'deactivate') + ' user account?',
            'Yes',
            'No',
            () => {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route('admin.users.set') }}',
                    type: 'POST',
                    data: {'user_id': id},
                    dataType: 'json',
                    success: function (response) {
                        Report.success(
                            'Report',
                            'User account ' + ((response) ? 'activated' : 'deactivated') + ' successfully.',
                            'Okay',
                            {
                                backOverlay: false,
                            },
                        );
                    },
                });
            },
            () => {
                checkbox.checked = !checked;
            },
            {
                backOverlay: false,
            },
        );
    }
</script>
