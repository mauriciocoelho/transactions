<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use Uuids;
    use HasFactory;
    
    public $timestamps = false;

    protected $fillable = [
        'title', 'value', 'type',
    ];
}
