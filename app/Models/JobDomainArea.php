<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobDomainArea extends Model
{
    use HasFactory;
    protected $fillable = ['rn_no_id','job_id','domain_area_id','status'];
    protected $table = "job_domain_area";

}
