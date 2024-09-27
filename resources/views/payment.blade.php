<x-layout>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Payment</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <script src="https://js.stripe.com/v3/"></script>
    </head>
    <body class="bg-gray-100 p-4">
        <div class="container mx-auto">
            <div class="bg-white p-6 border rounded-md shadow-md">
                <h2 class="text-2xl font-semibold mb-4">Payment Information</h2>
                <form id="payment-form" action="{{ route('payment.process') }}" method="POST">

                    @csrf


                    <!-- Card Element -->
                    <div class="mb-4">
                        <label class="block text-gray-700">Card Details</label>
                        <div id="card-element" class="mt-1 p-2 border border-gray-300 rounded-md"></div>
                        <div id="card-errors" role="alert" class="text-red-500 mt-2"></div>
                    </div>

                    <!-- Cash Payment Option -->
                    <div class="mb-4">
                        <label class="block text-gray-700">Payment Method</label>
                        <div class="mt-2">
                            <label class="inline-flex items-center">
                                <input type="radio" class="form-radio" name="payment_method" value="card" checked>
                                <span class="ml-2">Credit Card</span>
                            </label>
                            <label class="inline-flex items-center ml-4">
                                <input type="radio" class="form-radio" name="payment_method" value="cash">
                                <span class="ml-2">Cash on Delivery</span>
                            </label>
                        </div>
                    </div>

                    <button id="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Submit Payment</button>
                </form>
            </div>
        </div>

        <script>
            const stripe = Stripe('pk_test_51Q3fmI2NKuWOPFn1zx2cVSlGU5vEORtR3TkD4v9KcudNMm6duNPTt3HDGJiCMj8WotT6iEXkiYHXiBpbFSKW7dIB00dm9rBg03'); // Replace with your own publishable key
            const elements = stripe.elements();
            const cardElement = elements.create('card');
            cardElement.mount('#card-element');

            // Handle form submission
            const form = document.getElementById('payment-form');
            form.addEventListener('submit', async (event) => {
                event.preventDefault();

                // Check if cash payment is selected
                const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

                if (paymentMethod === 'cash') {
                    // Redirect to success page directly for cash payments
                    window.location.href = "{{ route('payment.success') }}";
                } else {
                    // Handle Stripe card payment
                    const { paymentMethod, error } = await stripe.createPaymentMethod({
                        type: 'card',
                        card: cardElement,
                    });

                    if (error) {
                        // Display error in #card-errors
                        document.getElementById('card-errors').textContent = error.message;
                    } else {
                        // Send paymentMethod.id to your server
                        const hiddenInput = document.createElement('input');
                        hiddenInput.setAttribute('type', 'hidden');
                        hiddenInput.setAttribute('name', 'payment_method_id');
                        hiddenInput.setAttribute('value', paymentMethod.id);
                        form.appendChild(hiddenInput);

                        form.submit(); // Submit the form for card payments
                    }
                }
            });
        </script>
    </body>
    </html>
</x-layout>
