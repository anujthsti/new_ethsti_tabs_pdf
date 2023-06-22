<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Results extends Model
{
    use HasFactory;
    protected $fillable = ['rn_no_id','job_id','result_title','showing_till_date','alternate_text','upload_file','announcement','email','status'];
    protected $table = "results";

}
