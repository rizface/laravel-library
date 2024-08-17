<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'categories';
    protected $fillable = [
        'name'
    ];

    public static function CategoryAlreadyExists($name) {
        return self::where(DB::raw("LOWER(name)"), strtolower($name))->count() > 0;
    }
}
