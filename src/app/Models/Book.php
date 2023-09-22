<?php

namespace App\Models;

use App\Http\Traits\BindsDynamically;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use BindsDynamically;
}
