<?php

namespace Lancodev\LunarBraintree\Components;

use Braintree\Gateway;
use Livewire\Component;
use Lunar\Facades\CartSession;
use Lunar\Models\Cart;
use Lunar\Models\Country;

class PaymentForm extends Component
{
    public Cart $cart;

    public $returnUrl;

    public $policy;

    protected $listeners = [
        'createOrder',
        'onApprove',
        'cartUpdated' => 'refreshCart',
        'selectedShippingOption' => 'refreshCart',
    ];

    public function mount()
    {
        $gateway = new Gateway([
            'environment' => config('lunar-braintree.environment'),
            'merchantId' => config('lunar-braintree.merchant_id'),
            'publicKey' => config('lunar-braintree.public_key'),
            'privateKey' => config('lunar-braintree.private_key'),
        ]);
    }

    public function createOrder($data)
    {
        logger('creating order');
        logger($data);
    }

    public function onApprove($data)
    {
        logger('on approve');
        logger($data);

        $shippingName = explode(' ', $data['purchase_units'][0]['shipping']['name']['full_name']);
        $shippingAddress = $data['purchase_units'][0]['shipping']['address'];

        $this->cart->setShippingAddress([
            'first_name' => $shippingName[0],
            'last_name' => $shippingName[1],
            'line_one' => $shippingAddress['address_line_1'],
            'line_two' => $shippingAddress['address_line_2'],
            'city' => $shippingAddress['admin_area_2'],
            'state' => $shippingAddress['admin_area_1'],
            'postcode' => $shippingAddress['postal_code'],
            'country_id' => Country::where('iso2', $shippingAddress['country_code'])->first()->id,
        ]);

        $this->cart->createOrder();

        return redirect()->to($this->returnUrl);
    }

    public function submit()
    {
        logger('submitting');
    }

    public function refreshCart()
    {
        $this->cart = CartSession::current();
    }

    public function render()
    {
        return view('lunar-braintree::braintree.components.payment-form');
    }
}
