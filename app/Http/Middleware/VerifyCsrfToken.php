<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'application/payment_response',
        'application/pay_receipt',
        'application/croneCheckCandidatePaymentStatus',
        'application/final_submission_after_payment'
    ];
}
