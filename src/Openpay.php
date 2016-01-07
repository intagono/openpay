<?php namespace Intagono\Openpay;

use App\Models\Holder;
use OpenpayApi as OpenpayCore;

class Openpay {

    /**
     * The Openpay core.
     *
     * @var \OpenpayCore
     */
    protected $core;

    /**
     * Constructor.
     */
    public function __construct(OpenpayCore $core)
    {
        $this->core = $core;
    }

    /**
     * Retreives the Openpay core.
     *
     * @return \OpenpayCore
     */
    public function getCore()
    {
        return $this->core;
    }

    //Customers Section

    /**
     * Create a new customer.
     *
     * @return \OpenpayCustomer
     */
    public function createCustomer($customerData)
    {
        $customer = $this->core->customers->add($customerData);

        $database = config('openpay.database', false);

        if($database){
            Holder::create(
                array(
                    "openpay_id" => $customer->id,
                    "name" => $customerData["name"],
                    "last_name" => $customerData["last_name"],
                    "email" => $customerData["email"],
                    "phone_number" => $customerData["phone_number"],
                )
            );
        }

        return $customer;
    }

    /**
     * Get an existing customer.
     *
     * @return \Intagono\Openpay\Customer
     */
    public function customer($customerId)
    {
        $coreCustomer = $this->core->customers->get($customerId);

        return new Customer($coreCustomer);
    }

    /**
     * Delete an existing customer.
     *
     * @return void
     */
    public function deleteCustomer($customerId)
    {
        $coreCustomer = $this->core->customers->get($customerId);

        $coreCustomer->delete();
    }

    /**
     * List of customers.
     *
     * @return array
     */
    public function customers(array $findDataRequest)
    {
        return $this->core->customers->getList($findDataRequest);
    }

    //End Customers Section

    //Cards Section

    /**
     * Create a new card.
     *
     * @return \OpenpayCard
     */
    public function createCard($cardDataRequest)
    {
        return $this->core->cards->add($cardDataRequest);
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

        return $this->core->cards->add($cardDataRequest);
    }

    /**
     * Get an existing card.
     *
     * @return \OpenpayCard
     */
    public function card($cardId)
    {
        return $this->core->cards->get($cardId);
    }

    /**
     * Delete an existing card.
     *
     * @return void
     */
    public function deleteCard($cardId)
    {
        $card = $this->core->card->get($cardId);

        $card->delete();
    }

    /**
     * List of cards.
     *
     * @return array
     */
    public function cards(array $findDataRequest)
    {
        return $this->core->cards->getList($findDataRequest);
    }

    //End Cards Section

    //Charges Section

    /**
     * Charges a customer.
     *
     * @return \OpenpayCharge
     */
    public function createCharge($chargeRequest)
    {
        return $this->core->charges->create($chargeRequest);
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

        return $this->core->charges->create($chargeRequest);
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

        return $this->core->charges->create($chargeRequest);
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

        return $this->core->charges->create($chargeRequest);
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

        return $this->core->charges->create($chargeRequest);
    }

    /**
     * Create payment reference for payments in stores.
     *
     * Example for due_date 2014-08-01 or 01/08/2014
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

        return $this->core->charges->create($chargeRequest);
    }

    /**
     * Confirm a reserve charge with the transaction_id.
     *
     * @return \OpenpayCharge
     */
    public function confirmCharge($transaction_id, $amount)
    {
        $charge = $this->core->charges->get($transaction_id);
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

        $charge = $this->core->charges->get($transaction_id);
        return $charge->refund($refundData);
    }

    /**
     * Get a charge with the transaction_id.
     *
     * @return \OpenpayCharge
     */
    public function charge($transaction_id)
    {
        return $this->core->charges->get($transaction_id);
    }

    /**
     * Get a customer's charges list.
     *
     * @return \OpenpayCharge
     */
    public function charges($searchParams = array())
    {
        return $this->core->charges->getList($searchParams);
    }

    //End Charges Section

    //Plans Section

    /**
     * Create a new plan.
     *
     * @return \OpenpayPlan
     */
    public function createPlan($planDataRequest)
    {
        return $this->core->plans->add($planDataRequest);
    }

    /**
     * Get an existing plan.
     *
     * @return \OpenpayPlan
     */
    public function plan($planId)
    {
        return $this->core->plans->get($planId);
    }

    /**
     * Delete an existing plan.
     *
     * @return void
     */
    public function deletePlan($planId)
    {
        $plan = $this->core->plans->get($planId);

        $plan->delete();
    }

    /**
     * List of plans.
     *
     * @return array
     */
    public function plans(array $findDataRequest)
    {
        return $this->core->plans->getList($findDataRequest);
    }

    //End Plans Section
}