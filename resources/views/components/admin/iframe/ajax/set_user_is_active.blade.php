<script>
    function setUserIsActive(id, checkbox) {
        let checked = checkbox.checked;
        Confirm.show(
            'Confirmation',
            'Do you want to ' + ((checked) ? 'activate' : 'deactivate') + ' client account?',
            'Yes',
            'No',
            () => {
                $.ajax({
                    url: '{{ route('admin.users.set') }}',
                    type: 'POST',
                    data: {'user_id': id},
                    dataType: 'json',
                    success: function (response) {
                        Report.success(
                            'Report',
                            'Client account ' + ((response) ? 'activated' : 'deactivated') + ' successfully.',
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
