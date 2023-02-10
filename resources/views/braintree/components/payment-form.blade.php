<div>
    {{--BrainTree--}}
    <div id="dropin-container"></div>
    <button id="submit-button"
            class="flex mt-4 items-center px-5 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-500 disabled:opacity-50"
    >Purchase</button>


    <script>
        var submitButton = document.querySelector('#submit-button');

        braintree.dropin.create({
            authorization: 'eyJ2ZXJzaW9uIjoyLCJhdXRob3JpemF0aW9uRmluZ2VycHJpbnQiOiJleUowZVhBaU9pSktWMVFpTENKaGJHY2lPaUpGVXpJMU5pSXNJbXRwWkNJNklqSXdNVGd3TkRJMk1UWXRjMkZ1WkdKdmVDSXNJbWx6Y3lJNkltaDBkSEJ6T2k4dllYQnBMbk5oYm1SaWIzZ3VZbkpoYVc1MGNtVmxaMkYwWlhkaGVTNWpiMjBpZlEuZXlKbGVIQWlPakUyTnpZeE5EVTJNelVzSW1wMGFTSTZJakU1WTJGaFkyRXlMVEF4WkRFdE5EVmxaUzA0Tm1WbExUVmlPVFF6TmpoaVlXVmlNQ0lzSW5OMVlpSTZJak40WmpocU9XWjJjakowY1doNWN6VWlMQ0pwYzNNaU9pSm9kSFJ3Y3pvdkwyRndhUzV6WVc1a1ltOTRMbUp5WVdsdWRISmxaV2RoZEdWM1lYa3VZMjl0SWl3aWJXVnlZMmhoYm5RaU9uc2ljSFZpYkdsalgybGtJam9pTTNobU9HbzVablp5TW5SeGFIbHpOU0lzSW5abGNtbG1lVjlqWVhKa1gySjVYMlJsWm1GMWJIUWlPblJ5ZFdWOUxDSnlhV2RvZEhNaU9sc2liV0Z1WVdkbFgzWmhkV3gwSWwwc0luTmpiM0JsSWpwYklrSnlZV2x1ZEhKbFpUcFdZWFZzZENKZExDSnZjSFJwYjI1eklqcDdmWDAudGxOTnVKTHhQV091VGl4dXhuaHhlVzhSamNQUWkyM2dPNDFQNGhxSlVLaURfQ3o0RkdudEh0bW1OeUphNl9nS3dCdGF6RHN2MVRiMndaS2toYjJmUUEiLCJjb25maWdVcmwiOiJodHRwczovL2FwaS5zYW5kYm94LmJyYWludHJlZWdhdGV3YXkuY29tOjQ0My9tZXJjaGFudHMvM3hmOGo5ZnZyMnRxaHlzNS9jbGllbnRfYXBpL3YxL2NvbmZpZ3VyYXRpb24iLCJncmFwaFFMIjp7InVybCI6Imh0dHBzOi8vcGF5bWVudHMuc2FuZGJveC5icmFpbnRyZWUtYXBpLmNvbS9ncmFwaHFsIiwiZGF0ZSI6IjIwMTgtMDUtMDgiLCJmZWF0dXJlcyI6WyJ0b2tlbml6ZV9jcmVkaXRfY2FyZHMiXX0sImNsaWVudEFwaVVybCI6Imh0dHBzOi8vYXBpLnNhbmRib3guYnJhaW50cmVlZ2F0ZXdheS5jb206NDQzL21lcmNoYW50cy8zeGY4ajlmdnIydHFoeXM1L2NsaWVudF9hcGkiLCJlbnZpcm9ubWVudCI6InNhbmRib3giLCJtZXJjaGFudElkIjoiM3hmOGo5ZnZyMnRxaHlzNSIsImFzc2V0c1VybCI6Imh0dHBzOi8vYXNzZXRzLmJyYWludHJlZWdhdGV3YXkuY29tIiwiYXV0aFVybCI6Imh0dHBzOi8vYXV0aC52ZW5tby5zYW5kYm94LmJyYWludHJlZWdhdGV3YXkuY29tIiwidmVubW8iOiJvZmYiLCJjaGFsbGVuZ2VzIjpbImN2diJdLCJ0aHJlZURTZWN1cmVFbmFibGVkIjp0cnVlLCJhbmFseXRpY3MiOnsidXJsIjoiaHR0cHM6Ly9vcmlnaW4tYW5hbHl0aWNzLXNhbmQuc2FuZGJveC5icmFpbnRyZWUtYXBpLmNvbS8zeGY4ajlmdnIydHFoeXM1In0sInBheXBhbEVuYWJsZWQiOnRydWUsInBheXBhbCI6eyJiaWxsaW5nQWdyZWVtZW50c0VuYWJsZWQiOnRydWUsImVudmlyb25tZW50Tm9OZXR3b3JrIjpmYWxzZSwidW52ZXR0ZWRNZXJjaGFudCI6ZmFsc2UsImFsbG93SHR0cCI6dHJ1ZSwiZGlzcGxheU5hbWUiOiJDcmVhdGl2ZTIiLCJjbGllbnRJZCI6IkFmRE1OeVliNEZiQ0ZYMl9HaDREc0RTRkZtR01Vb0J5dWI0cWNrcG9RbllxdDBqVkh6RXdwMjFZRkhqRGkyRGt3ai1pTWRSVXFmeDhjUGR2IiwicHJpdmFjeVVybCI6Imh0dHA6Ly9leGFtcGxlLmNvbS9wcCIsInVzZXJBZ3JlZW1lbnRVcmwiOiJodHRwOi8vZXhhbXBsZS5jb20vdG9zIiwiYmFzZVVybCI6Imh0dHBzOi8vYXNzZXRzLmJyYWludHJlZWdhdGV3YXkuY29tIiwiYXNzZXRzVXJsIjoiaHR0cHM6Ly9jaGVja291dC5wYXlwYWwuY29tIiwiZGlyZWN0QmFzZVVybCI6bnVsbCwiZW52aXJvbm1lbnQiOiJvZmZsaW5lIiwiYnJhaW50cmVlQ2xpZW50SWQiOiJtYXN0ZXJjbGllbnQzIiwibWVyY2hhbnRBY2NvdW50SWQiOiJjcmVhdGl2ZTIiLCJjdXJyZW5jeUlzb0NvZGUiOiJVU0QifX0',
            container: '#dropin-container',
            card: {
                cardholderName: {
                    required: true
                },
                cvv: {
                    required: true
                },
                overrides: {
                    fields: {
                        cvv: {
                            maskInput: true
                        }
                    }
                }
            },
        }, function (err, dropinInstance) {
            if (err) {
                // Handle any errors that might've occurred when creating Drop-in
                console.error(err);
                return;
            }
            submitButton.addEventListener('click', function () {
                dropinInstance.requestPaymentMethod(function (err, payload) {
                    if (err) {
                        // Handle errors in requesting payment method
                    }

                    console.log(payload);

                    // Send payload.nonce to your server
                });
            });
        });
    </script>


</div>
