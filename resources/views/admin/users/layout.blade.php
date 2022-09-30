<x-admin.layout.management name="Clients Management">
    <x-slot:search>
        <div class="flex justify-center mb-5">
            <div class="flex items-center flex-col lg:flex-row space-y-2 lg:space-y-0">
                <x-form.label label="Full name"/>
                <x-form.input_text_only type="text" name="full_name"/>
            </div>
            <div class="flex items-center flex-col lg:flex-row space-y-2 lg:space-y-0 ml-10 mr-5 xl:min-w-[500px]">
                <x-form.label label="Email"/>
                <x-form.input_text_only type="email" name="email"/>
            </div>
        </div>
        <script>
            function search() {
                let parent_iframe = document.getElementById('{{ \App\Iframes\UserIframe::$parentIframeId }}');
                let url = '{{ route('admin.users') }}';
                let full_name = document.getElementById('full_name').value;
                let email = document.getElementById('email').value;
                if (full_name !== '' || email !== '') {
                    let full_name_splitted = full_name.split('/');
                    let query = new URLSearchParams();
                    if (full_name_splitted[0] ?? '' !== '') {
                        query.append('last_name', full_name_splitted[0].trim());
                    }
                    if (full_name_splitted[1] ?? '' !== '') {
                        console.log(full_name_splitted[1].trim().length);
                        query.append('first_name', full_name_splitted[1].trim());
                    }
                    if (email !== '') {
                        query.append('email', email);
                    }
                    parent_iframe.src = url + '?' + query.toString();
                } else {
                    parent_iframe.src = url;
                }
            }

            document.getElementById('full_name').addEventListener('keyup', search);
            document.getElementById('email').addEventListener('keyup', search);
        </script>
    </x-slot:search>
    <iframe id="{{ \App\Iframes\UserIframe::$parentIframeId }}" class="w-full"
            src="{{ route('admin.users') }}"></iframe>
    <x-admin.iframe.cu.layout :id="\App\Iframes\UserIframe::$iframeCUId" width-class="w-2/3" height-class="h-2/3"/>
</x-admin.layout.management>
