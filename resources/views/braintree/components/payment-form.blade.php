<div x-data>
    {{--BrainTree--}}
    <div id="dropin-container"></div>
    <button
        id="submit-button"
        x-ref="submitButton"
        class="flex mt-4 items-center px-5 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-500 disabled:opacity-50">
        Purchase
    </button>


    <script>
        var submitButton = document.querySelector('#submit-button');

        braintree.dropin.create({
            authorization: '{{ $clientToken }}',
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
                    Livewire.emit('paymentSubmitted', payload);

                    // Send payload.nonce to your server
                });
            });
        });
    </script>


</div>
