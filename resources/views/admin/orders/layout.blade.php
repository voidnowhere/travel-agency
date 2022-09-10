<x-admin.layout.management name="Orders Management" :load-jquery="true" :load-jquery-u-i="true">
    <x-slot:search>
        <div class="flex justify-center mb-5">
            <input type="hidden" id="user_id">
            <div class="flex items-center flex-col lg:flex-row space-y-2 lg:space-y-0">
                <x-form.label label="Full name"/>
                <x-form.input_text_only type="text" name="full_name"/>
            </div>
            <div class="flex items-center flex-col lg:flex-row space-y-2 lg:space-y-0 ml-10 mr-5 xl:min-w-[500px]">
                <x-form.label label="Email"/>
                <x-form.input_text_only type="email" name="email"/>
            </div>
            <x-form.submit on-click="search()">Search</x-form.submit>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                $('#email').keyup(function () {
                    $('#{{ \App\Iframes\OrderIframe::$parentIframeId }}').attr('src', '');
                    $('#user_id').val('');
                    $('#full_name').val('');
                    let value = $(this).val();
                    if (value !== '') {
                        $.ajax({
                            url: '{{ route('admin.users.get') }}',
                            type: 'POST',
                            data: {'email': value},
                            dataType: 'json',
                            success: function (response) {
                                let content = [];
                                response.forEach(function (item) {
                                    content.push({
                                        'id': item.id,
                                        'label': item.email,
                                        'last_name': item.last_name,
                                        'first_name': item.first_name,
                                    })
                                });
                                $("#email").autocomplete({
                                    source: content,
                                    classes: {
                                        "ui-autocomplete": "max-h-[200px] overflow-y-auto overflow-x-hidden"
                                    },
                                    focus: function (event, ui) {
                                        $("#full_name").val(ui.item.last_name + ' / ' + ui.item.first_name);
                                        return false;
                                    },
                                    select: function (event, ui) {
                                        $("#user_id").val(ui.item.id);
                                        $("#name").val(ui.item.last_name + ' / ' + ui.item.first_name);
                                        $("#email").val(ui.item.label);

                                        return false;
                                    }
                                }).autocomplete("instance")._renderItem = function (ul, item) {
                                    return $("<li>")
                                        .append("<div>" + item.label + "</div>")
                                        .appendTo(ul);
                                };
                            },
                        });
                    }
                });

                $('#full_name').keyup(function () {
                    $('#{{ \App\Iframes\OrderIframe::$parentIframeId }}').attr('src', '');
                    $('#user_id').val('');
                    $('#email').val('');
                    let value = $(this).val().split('/');
                    if (value[0] !== '') {
                        $.ajax({
                            url: '{{ route('admin.users.get') }}',
                            type: 'POST',
                            data: {
                                'last_name': value[0].trim(),
                                'first_name': value[1]?.trim(),
                            },
                            dataType: 'json',
                            success: function (response) {
                                let content = [];
                                response.forEach(function (item) {
                                    content.push({
                                        'id': item.id,
                                        'label': item.last_name + ' / ' + item.first_name,
                                        'email': item.email,
                                    })
                                });
                                $("#full_name").autocomplete({
                                    source: content,
                                    classes: {
                                        "ui-autocomplete": "max-h-[200px] overflow-y-auto overflow-x-hidden"
                                    },
                                    focus: function (event, ui) {
                                        $("#email").val(ui.item.email);
                                        return false;
                                    },
                                    select: function (event, ui) {
                                        $("#user_id").val(ui.item.id);
                                        $("#full_name").val(ui.item.label);
                                        $("#email").val(ui.item.email);
                                        return false;
                                    }
                                }).autocomplete("instance")._renderItem = function (ul, item) {
                                    return $("<li>")
                                        .append("<div>" + item.label + "</div>")
                                        .appendTo(ul);
                                };
                            },
                        });
                    }
                });
            });

            function search() {
                let url = '{{ route('admin.orders') }}';
                let user_id = $('#user_id').val();
                if (user_id !== '') {
                    $('#{{ \App\Iframes\OrderIframe::$parentIframeId }}').attr('src', url + `/${user_id}`);
                } else {
                    Notiflix.Report.failure(
                        'Error',
                        'Fill in email and full name',
                        'Okay',
                        {backOverlay: false,},
                    );
                }
            }
        </script>
    </x-slot:search>
    <iframe id="{{ \App\Iframes\OrderIframe::$parentIframeId }}" class="w-full"></iframe>
    <x-admin.iframe.cu.layout :id="\App\Iframes\OrderIframe::$iframeCUId" width-class="w-2/3" height-class="h-2/3"/>
</x-admin.layout.management>
