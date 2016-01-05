<?php namespace Intagono\Openpay;

use OpenpayCustomer;

class Customer {

    /**
     * An Openpay customer.
     *
     * @var \OpenpayCustomer
     */
    protected $coreCustomer;

    /**
     * Constructor.
     */
    public function __construct(OpenpayCustomer $coreCustomer)
    {
        $this->coreCustomer = $coreCustomer;
    }

    /**
     * Retreives the Openpay customer property.
     *
     * @return \mixed
     */
    public function __get($name)
    {
        return $this->coreCustomer->{$name};
    }

    /**
     * Update the Openpay customer property.
     *
     * @return \void
     */
    public function __set($name, $value)
    {
        $this->coreCustomer->{$name} = $value;
    }

    /**
     * Retreives the Openpay customer.
     *
     * @return \OpenpayCustomer
     */
    public function get()
    {
        return $this->coreCustomer;
    }

    /**
     * Save a customer properties.
     *
     * @return \OpenpayCustomer
     */
    public function save()
    {
        $this->coreCustomer->save();
    }

    /**
     * Update a customer.
     *
     * @return \OpenpayCustomer
     */
    public function update(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->coreCustomer->{$key} = $value;
        }

        $this->coreCustomer->save();

        return $this->coreCustomer;
    }

    /**
     * Delete a customer.
     *
     * @return \OpenpayCustomer
     */
    public function delete()
    {
        $this->coreCustomer->delete();
    }

    //Cards Section

    /**
     * Create a new card.
     *
     * @return \OpenpayCard
     */
    public function createCard($cardDataRequest)
    {
        return $this->coreCustomer->cards->add($cardDataRequest);
    }

    /**
     * Create a new card with a token and device session id.
     *
     * @return \OpenpayCard
     */
    public function createCardWithToken($token, $device_session_id)
    {
        $cardDataRequest = array(
            'token_id' => $token,
            'device_session_id' => $device_session_id
        );

        return $this->coreCustomer->cards->add($cardDataRequest);
    }

    /**
     * Get an existing card.
     *
     * @return \OpenpayCard
     */
    public function card($cardId)
    {
        return $this->coreCustomer->cards->get($cardId);
    }

    /**
     * Delete an existing card.
     *
     * @return void
     */
    public function deleteCard($cardId)
    {
        $card = $this->coreCustomer->card->get($cardId);

        $card->delete();
    }

    /**
     * List of cards.
     *
     * @return array
     */
    public function cards(array $findDataRequest)
    {
        return $this->coreCustomer->cards->getList($findDataRequest);
    }

    //End Cards Section

    //Banks Section

    /**
     * Create a new bank account.
     *
     * @return \OpenpayCard
     */
    public function createBankAccount($accountDataRequest)
    {
        return $this->coreCustomer->bankaccounts->add($accountDataRequest);
    }

    /**
     * Get an existing bank account.
     *
     * @return \OpenpayBankAccount
     */
    public function bankAccount($bankAccountId)
    {
        return $this->coreCustomer->bankaccounts->get($bankAccountId);
    }

    /**
     * Delete an existing bank account.
     *
     * @return void
     */
    public function deleteBankAccount($bankAccountId)
    {
        $bankAccount = $this->coreCustomer->bankaccounts->get($bankAccountId);

        $bankAccount->delete();
    }

    /**
     * List of bank accounts.
     *
     * @return array
     */
    public function bankAccounts(array $findDataRequest)
    {
        return $this->coreCustomer->bankaccounts->getList($findDataRequest);
    }

    //End Banks Section

    //Charges Section

    /**
     * Charges a customer.
     *
     * @return \OpenpayCharge
     */
    public function createCharge($chargeRequest)
    {
        return $this->coreCustomer->charges->create($chargeRequest);
    }

    /**
     * Charges a customer with a token.
     *
     * @return \OpenpayCharge
     */
    public function chargeWithToken($tokenId, $device_session_id, $amount, $description, $order_id = false)
    {
        $chargeRequest = array(
            'method' => 'card',
            'source_id' => $tokenId,
            'amount' => $amount,
            'currency' => 'MXN',
            'description' => $description,
            'capture' => true);

        if($device_session_id){
            $chargeRequest["device_session_id"] = $device_session_id;
        }

        if($order_id){
            $chargeRequest["order_id"] = $order_id;
        }

        return $this->coreCustomer->charges->create($chargeRequest);
    }

    /**
     * Charges a customer with a token.
     *
     * @return \OpenpayCharge
     */
    public function chargeWithCardId($tokenId, $device_session_id, $amount, $description, $order_id = false)
    {
        $chargeRequest = array(
            'method' => 'card',
            'source_id' => $tokenId,
            'amount' => $amount,
            'currency' => 'MXN',
            'description' => $description,
            'capture' => true);

        if($device_session_id){
            $chargeRequest["device_session_id"] = $device_session_id;
        }

        if($order_id){
            $chargeRequest["order_id"] = $order_id;
        }

        return $this->coreCustomer->charges->create($chargeRequest);
    }

    /**
     * Reserve Charges a customer with a token (preautorization).
     *
     * @return \OpenpayCharge
     */
    public function reserveWithTokenId($tokenId, $device_session_id, $amount, $description, $order_id = false)
    {
        $chargeRequest = array(
            'method' => 'card',
            'source_id' => $tokenId,
            'amount' => $amount,
            'currency' => 'MXN',
            'description' => $description,
            'capture' => false);

        if($device_session_id){
            $chargeRequest["device_session_id"] = $device_session_id;
        }

        if($order_id){
            $chargeRequest["order_id"] = $order_id;
        }

        return $this->coreCustomer->charges->create($chargeRequest);
    }

    /**
     * Charges a customer with a new card.
     *
     * @return \OpenpayCharge
     */
    public function chargeWithNewCard($card, $device_session_id, $amount, $description, $order_id = false)
    {
        $chargeRequest = array(
            'method' => 'card',
            'card' => $card,
            'amount' => $amount,
            'currency' => 'MXN',
            'description' => $description,
            'capture' => true);

        if($device_session_id){
            $chargeRequest["device_session_id"] = $device_session_id;
        }

        if($order_id){
            $chargeRequest["order_id"] = $order_id;
        }

        return $this->coreCustomer->charges->create($chargeRequest);
    }

    /**
     * Create payment reference for payments in stores.
     *
     * Example for due_date 2014-08-01 or 01/08/2014
     * Example for due_date 2014-08-01T11:51:23-05:00
     *
     * @return \OpenpayCharge
     */
    public function storeReferencePayment($amount, $description, $order_id = false, $due_date = false, $due_hour = false)
    {
        $chargeRequest = array(
            'method' => 'store',
            'amount' => $amount,
            'description' => $description);

        if($order_id){
            $chargeRequest["order_id"] = $order_id;
        }

        if($due_date){
            $date = explode("-", date("Y-m-d"));
            if(strpos($due_date, "-") !== false){
                $date = explode("-", $due_date);

                $due_date = $date[0]."-".$date[1]."-".$date[2];
            }
            elseif(strpos($due_date, "/") !== false){
                $date = explode("/", $due_date);

                $due_date = $date[2]."-".$date[1]."-".$date[0];
            }

            $due_date .= "T";

            if($due_hour){
                $due_date .= $due_hour;
            }
            else {
                $due_date .= "23:59:59";
            }

            $chargeRequest["due_date"] = $due_date;
        }

        return $this->coreCustomer->charges->create($chargeRequest);
    }

    /**
     * Confirm a reserve charge with the transaction_id.
     *
     * @return \OpenpayCharge
     */
    public function confirmCharge($transaction_id, $amount)
    {
        $charge = $this->coreCustomer->charges->get($transaction_id);
        return $charge->capture($amount);
    }

    /**
     * Refund a charge with the transaction_id.
     *
     * @return \OpenpayCharge
     */
    public function refundCharge($transaction_id, $description)
    {
        $refundData = array('description' => $description);

        $charge = $this->coreCustomer->charges->get($transaction_id);
        return $charge->refund($refundData);
    }

    /**
     * Get a charge with the transaction_id.
     *
     * @return \OpenpayCharge
     */
    public function charge($transaction_id)
    {
        return $this->coreCustomer->charges->get($transaction_id);
    }

    /**
     * Get a customer's charges list.
     *
     * @return \OpenpayCharge
     */
    public function charges($searchParams = array())
    {
        return $this->coreCustomer->charges->getList($searchParams);
    }

    //End Charges Section

    //Subscriptions Section

    /**
     * Create a new Subscription.
     *
     * @return \OpenpaySubscription
     */
    public function createSubscription($subscriptionDataRequest)
    {
        return $this->core->subscriptions->add($subscriptionDataRequest);
    }

    /**
     * Get an existing Subscription.
     *
     * @return \OpenpaySubscription
     */
    public function subscription($subscriptionId)
    {
        return $this->core->subscriptions->get($subscriptionId);
    }

    /**
     * Delete an existing Subscription.
     *
     * @return void
     */
    public function deleteSubscription($subscriptionId)
    {
        $subscription = $this->core->subscriptions->get($subscriptionId);

        $subscription->delete();
    }

    /**
     * List of Subscriptions.
     *
     * @return array
     */
    public function subscriptions(array $findDataRequest)
    {
        return $this->core->subscriptions->getList($findDataRequest);
    }

    //End Subscriptions Section
}