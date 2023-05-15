<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategoryWiseFee extends Model
{
    use HasFactory;
    protected $fillable = ['post_id','job_validation_id','fee_category_id','fee','status'];
    protected $table = "job_application_fee_trans";

}
