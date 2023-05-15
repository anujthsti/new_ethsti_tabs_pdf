<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeCroneJob extends Model
{
    use HasFactory;
    protected $fillable = ['status'];
    protected $table = "fee_crone_job";
}
