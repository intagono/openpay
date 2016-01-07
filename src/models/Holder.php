<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Holder extends Model {
    protected $fillable = array('openpay_id', 'name', 'last_name', 'email', 'phone_number');
}