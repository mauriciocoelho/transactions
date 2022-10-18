<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Transaction extends Model
{
    use Uuids;
    use HasFactory;
    use SoftDeletes;

    protected $table = 'transactions';
    

    protected $fillable = [
        'title', 'value', 'type',
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y h:m',
        'updated_at' => 'datetime:d/m/Y h:m',
        'deleted_at' => 'datetime:d/m/Y h:m',
    ];

    protected $guarded = ['id'];
}
