<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobAgeRelaxation extends Model
{
    use HasFactory;
    protected $fillable = ['post_id','job_validation_id','category_id','years','status'];
    protected $table = "job_age_limit_validation_trans";

}
