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