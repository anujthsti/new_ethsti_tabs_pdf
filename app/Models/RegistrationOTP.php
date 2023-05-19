<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationOTP extends Model
{
    use HasFactory;
    protected $fillable = ['email_id','otp','status'];
    protected $table = "registration_otp";
}
