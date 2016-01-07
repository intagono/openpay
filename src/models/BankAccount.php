<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model {
    protected $fillable = array('openpay_id', 'holder_name', 'clabe', 'bank_name', 'bank_code', 'alias');
}
