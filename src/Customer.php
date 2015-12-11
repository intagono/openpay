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
     * Retreives the Openpay customer.
     *
     * @return \OpenpayCustomer
     */
    public function get()
    {
        return $this->coreCustomer;
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

}