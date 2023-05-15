<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeStatusTransactions extends Model
{
    use HasFactory;
    protected $fillable = ['job_apply_id','pay_status_code','code_description'];
    protected $table = "fee_status_transactions";

}
