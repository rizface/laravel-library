<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'config';
    protected $fillable = [
        'cost_overdue_per_day',
    ];
}
