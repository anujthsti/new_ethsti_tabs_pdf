<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamCenters extends Model
{
    use HasFactory;
    protected $fillable = ['centre_name','centre_address','centre_location','status'];
    protected $table = "exam_centers";

}
