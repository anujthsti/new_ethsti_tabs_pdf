<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Syllabus extends Model
{
    use HasFactory;
    protected $fillable = ['rn_no_id','job_id','syllabus_title','showing_till_date','alternate_text','upload_file','status'];
    protected $table = "syllabus";

}
