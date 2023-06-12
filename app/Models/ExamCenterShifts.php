<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamCenterShifts extends Model
{
    use HasFactory;
    protected $fillable = ['exam_center_map_id','job_id','is_exam_or_interview','reporting_date','reporting_time','status'];
    protected $table = "exam_center_shifts";

}
