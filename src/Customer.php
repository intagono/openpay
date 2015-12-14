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

    /**
     * Charges a customer.
     *
     * @return \OpenpayCharge
     */
    public function charge($chargeRequest)
    {
        return $this->coreCustomer->charges->create($chargeRequest);
    }

    /**
     * Create a new Customer's Card.
     *
     * @return \OpenpayCard
     */
    public function createCard($cardDataRequest)
    {
        return $this->coreCustomer->cards->add($cardDataRequest);
    }

    public function cards($cardDataRequest = array())
    {
        return $this->coreCustomer->cards->getList($cardDataRequest);
    }

}