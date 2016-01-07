<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model {
    protected $fillable = array('openpay_id', 'customer_id', 'type', 'brand', 'holder_name', 'card_number', 'expiration_month', 'expiration_year', 'bank_name', 'bank_code');
}