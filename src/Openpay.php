<?php namespace Intagono\Openpay;

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
        return $this->core->customers->add($customerData);
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

    /**
     * Charges a card, store or bank.
     *
     * @return \OpenpayCharge
     */
    public function charge($chargeRequest)
    {
        return $this->core->charges->create($chargeRequest);
    }
}