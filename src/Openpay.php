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

    /**
     * Charges a card, store or bank.
     *
     * @return \OpenpayCharge
     */
    public function charge($chargeRequest)
    {
        return $this->core->charges->create($chargeRequest);
    }

    /**
     * Create a new card.
     *
     * @return \OpenpayCard
     */
    public function createCard($cardData)
    {
        return $this->core->cards->add($cardData);
    }

}