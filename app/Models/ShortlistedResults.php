<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortlistedResults extends Model
{
    use HasFactory;
    protected $fillable = ['rn_no_id','job_id','shortlisted_title','date_of_interview','alternate_text','upload_file','announcement','status'];
    protected $table = "shortlisted_results";

}
