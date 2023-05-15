<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HRRemarks extends Model
{
    use HasFactory;
    protected $fillable = ['category','code','remarks_desc','status'];
    protected $table = "apply_job_hr_remarks";

}
