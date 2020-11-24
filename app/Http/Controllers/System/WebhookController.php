<?php

namespace App\Http\Controllers\System;

use App\Zen\System\Model\Team;
use Hyn\Tenancy\Models\Website;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Laravel\Spark\Contracts\Repositories\LocalInvoiceRepository;
use Laravel\Spark\Http\Controllers\Settings\Billing\StripeWebhookController;
use Laravel\Spark\Spark;

class WebhookController extends StripeWebhookController
{
    /**
     * Get the billable entity instance by Stripe ID.
     *
     * @param string $stripeId
     * @return \Laravel\Cashier\Billable
     */
    protected function getUserByStripeId($stripeId)
    {
        $this -> switchToTenant($stripeId);

        $team = Team ::where('stripe_id', $stripeId) -> first();

        return $team;
    }

    /**
     * Identifies tenant and switch the current Environment to that tenant
     *
     * @param string $subscriptionId
     * @return void
     */
    protected function switchToTenant($stripeCustomerId)
    {
        $website = Website ::where('stripe_customer_id', $stripeCustomerId) -> first();
        $environment = app(\Hyn\Tenancy\Environment::class);
        $environment -> tenant($website);
    }

    /**
     * Handle customer subscription updated.
     *
     * @param  array $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleCustomerSubscriptionUpdated(array $payload)
    {
        $user = $this->getUserByStripeId(
            $payload['data']['object']['customer']
        );

        return $this->handleTeamSubscriptionUpdated($payload);

    }


    /**
     * Handle a successful invoice payment from a Stripe subscription.
     *
     * By default, this e-mails a copy of the invoice to the customer.
     *
     * @param array $payload
     * @return \Illuminate\Http\Response
     */
    protected function handleInvoicePaymentSucceeded(array $payload)
    {
        $user = $this -> getUserByStripeId(
            $payload['data']['object']['customer']
        );

        if(is_null($user)) {
            return $this -> teamInvoicePaymentSucceeded($payload);
        }

        $invoice = $user -> findInvoice($payload['data']['object']['id']);

        app(LocalInvoiceRepository::class) -> createForUser($user, $invoice);

        $this -> sendInvoiceNotification(
            $user, $invoice
        );

        return new Response('Webhook Handled', 200);
    }

    /**
     * Handle a successful invoice payment from a Stripe subscription.
     *
     * @param array $payload
     * @return \Illuminate\Http\Response
     */
    protected function teamInvoicePaymentSucceeded(array $payload)
    {
        $team = Spark ::team() -> where(
            'stripe_id', $payload['data']['object']['customer']
        ) -> first();

        if(is_null($team)) {
            return;
        }

        $invoice = $team -> findInvoice($payload['data']['object']['id']);

        $this -> createForBillable($team, $invoice);

        $this -> sendInvoiceNotification(
            $team, $invoice
        );

        return new Response('Webhook Handled', 200);
    }

    /**
     * Create a local invoice for the given billable entity.
     *
     * @param mixed $billable
     * @param \Laravel\Cashier\Invoice $invoice
     * @return \Laravel\Spark\LocalInvoice
     */
    protected function createForBillable($billable, $invoice)
    {
        if($existing = $billable -> localInvoices() -> where('provider_id', $invoice -> id) -> first()) {
            return $existing;
        }

        return $billable -> localInvoices() -> create([
            'provider_id' => $invoice -> id,
            'customer_id' => $billable -> customer_id,
            'total' => $invoice -> rawTotal() / 100,
            'tax' => $invoice -> asStripeInvoice() -> tax / 100,
            'card_country' => $billable -> card_country,
            'billing_state' => $billable -> billing_state,
            'billing_zip' => $billable -> billing_zip,
            'billing_country' => $billable -> billing_country,
            'vat_id' => $billable -> vat_id,
        ]);
    }

}