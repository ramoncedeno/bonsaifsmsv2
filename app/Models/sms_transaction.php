<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class sms_transaction extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'sms_transactions';

    protected $fillable = [

        'phone',
        'message',
        'response',

     ];

}
