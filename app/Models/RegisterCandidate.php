<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterCandidate extends Model
{
    use HasFactory;
    protected $fillable = ['email_id','mobile_no','salutation','full_name','father_name','mother_name','dob','gender','nationality_type','nationality','correspondence_address','cors_state_id','cors_city','cors_pincode','permanent_address','perm_state_id','perm_city','perm_pincode','status'];
    protected $table = "register_candidates";
}
