<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamCenterMapping extends Model
{
    use HasFactory;
    protected $fillable = ['rn_no_id','job_id','exam_center_id','status'];
    protected $table = "exam_center_mapping";

}
