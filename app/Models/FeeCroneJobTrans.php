<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeCroneJobTrans extends Model
{
    use HasFactory;
    protected $fillable = ['fee_crone_job_id','status_code','msg_body'];
    protected $table = "fee_crone_job_trans";
}
