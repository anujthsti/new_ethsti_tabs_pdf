<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormTabs extends Model
{
    use HasFactory;
    protected $fillable = ['tab_title','sort_order','status'];
    protected $table = "form_tabs";

}
