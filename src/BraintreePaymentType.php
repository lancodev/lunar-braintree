<?php

namespace Lancodev\LunarBraintree;

use Lunar\Base\DataTransferObjects\PaymentAuthorize;
use Lunar\Base\DataTransferObjects\PaymentCapture;
use Lunar\Base\DataTransferObjects\PaymentRefund;
use Lunar\Models\Transaction;
use Lunar\PaymentTypes\AbstractPayment;

class BraintreePaymentType extends AbstractPayment
{

    /**
     * @inheritDoc
     */
    public function authorize(): PaymentAuthorize
    {
        // TODO: Implement authorize() method.
    }

    /**
     * @inheritDoc
     */
    public function refund(Transaction $transaction, int $amount, $notes = null): PaymentRefund
    {
        // TODO: Implement refund() method.
    }

    /**
     * @inheritDoc
     */
    public function capture(Transaction $transaction, $amount = 0): PaymentCapture
    {
        // TODO: Implement capture() method.
    }
}
