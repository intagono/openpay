<?php namespace Intagono\Openpay;

class Openpay {

    protected $core;

    public function __construct($core)
    {
        $this->core = $core;
    }

    public function getCore()
    {
        return $this->core;
    }

    public function charge()
    {
        return $this->core->charges->create([
            'method' => 'bank_account',
            'amount' => 100,
            'description' => 'Cargo con banco',
            'order_id' => 'oid-00051'
        ]);
    }

    public function chargeCustomer()
    {
        
    }

}