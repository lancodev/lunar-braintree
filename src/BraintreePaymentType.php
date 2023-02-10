<?php

namespace Lancodev\LunarBraintree;

use Braintree\Gateway;
use Illuminate\Support\Facades\DB;
use Lunar\Base\DataTransferObjects\PaymentAuthorize;
use Lunar\Base\DataTransferObjects\PaymentCapture;
use Lunar\Base\DataTransferObjects\PaymentRefund;
use Lunar\Models\Transaction;
use Lunar\PaymentTypes\AbstractPayment;

class BraintreePaymentType extends AbstractPayment
{
    public $braintree;

    public $policy;

    public function __construct()
    {
        $this->braintree = new Gateway([
            'environment' => config('lunar-braintree.environment'),
            'merchantId' => config('lunar-braintree.merchant_id'),
            'publicKey' => config('lunar-braintree.public_key'),
            'privateKey' => config('lunar-braintree.private_key'),
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function authorize(): PaymentAuthorize
    {
        if (! $this->order) {
            if (! $this->order = $this->cart->order) {
                $this->order = $this->cart->createOrder();
            }
        }

        if ($this->order->placed_at) {
            // Something's gone wrong!
            return new PaymentAuthorize(
                success: false,
                message: 'This order has already been placed',
            );
        }

        $this->transaction = $this->braintree->transaction()->find(
            $this->data['transaction_id']
        );

        if ($this->transaction->status == 'authorized' && $this->policy == 'automatic') {
            $this->transaction = $this->braintree->transaction()->submitForSettlement(
                $this->data['transaction_id'],
                $this->order->total
            );
        }

        if ($this->cart) {
            if (! $this->cart->meta) {
                $this->cart->update([
                    'meta' => [
                        'transaction_id' => $this->transaction->id,
                    ],
                ]);
            } else {
                $this->cart->meta->transaction_id = $this->transaction->id;
                $this->cart->meta = $this->cart->meta;
                $this->cart->save();
            }
        }

        if (! in_array($this->transaction->status, [
            'settlement_pending',
            'settling',
            'settled',
            'submitted_for_settlement',
        ])) {
            return new PaymentAuthorize(
                success: false,
                message: 'The transaction was not successful',
            );
        }

        return $this->releaseSuccess();
    }

    /**
     * {@inheritDoc}
     */
    public function refund(Transaction $transaction, int $amount, $notes = null): PaymentRefund
    {
        try {
            $refund = $this->braintree->transaction()->refund($transaction->reference, $amount / 100);
        } catch (InvalidRequestException $e) {
            return new PaymentRefund(
                success: false,
                message: $e->getMessage()
            );
        }

        $transaction->order->transactions()->create([
            'success' => $refund->success,
            'type' => 'refund',
            'driver' => 'braintree',
            'amount' => $amount,
            'reference' => $refund->id,
            'status' => $refund->status,
            'notes' => $notes,
            'card_type' => $refund->creditCard->cardType,
            'last_four' => $refund->creditCard->last4,
        ]);

        return new PaymentRefund(
            success: true
        );
    }

    /**
     * {@inheritDoc}
     */
    public function capture(Transaction $transaction, $amount = 0): PaymentCapture
    {
        // TODO: Implement capture() method.
    }

    /**
     * Return a successfully released payment.
     *
     * @return PaymentAuthorize
     */
    private function releaseSuccess()
    {
        DB::transaction(function () {
            // Get our first successful charge.
            $transaction = $this->braintree->transaction()->find(
                $this->data['transaction_id']
            );
            $charges = $transaction->statusHistory;

            $this->order->update([
                'status' => $this->config['released'] ?? 'paid',
                'placed_at' => now()->parse($transaction->createdAt),
            ]);

            $transactions = [];

            $type = 'capture';

            if ($this->policy == 'manual') {
                $type = 'intent';
            }

            foreach ($charges as $charge) {
                $card = $transaction->creditCard;
                $transactions[] = [
                    'success' => $charge->status != 'failed',
                    'type' => $type,
                    'driver' => 'braintree',
                    'amount' => $charge->amount,
                    'status' => $charge->status,
                    'card_type' => $card->cardType,
                    'last_four' => $card->last4,
                    'captured_at' => $charge->timestamp,
                    'meta' => [
                        'address_line1_check' => $transaction->avsStreetAddressResponseCode,
                        'address_postal_code_check' => $transaction->avsPostalCodeResponseCode,
                        'cvc_check' => $transaction->cvvResponseCode,
                    ],
                ];
            }
            $this->order->transactions()->createMany($transactions);
        });

        return new PaymentAuthorize(success: true);
    }
}
