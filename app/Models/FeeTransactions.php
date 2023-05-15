<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeTransactions extends Model
{
    use HasFactory;
    protected $fillable = ['job_apply_id','merchant_id','customer_id','email','mobile','name','checksum','msg','currency_type','txn_amount','txn_reference_no','txn_charges','txn_date','bank_ref_no','bank_id','pay_status','error_status','error_description','checksum_res','msg_res','sms_res','sms_id','sms_status','method'];
    protected $table = "fee_transactions";
}
