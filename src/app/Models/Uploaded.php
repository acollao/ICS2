<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uploaded extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'uploaded_excel';

    protected $fillable = [
		'date_uploaded', 'filename', 'username', 'ip'
	];
}
