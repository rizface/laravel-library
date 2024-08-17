<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookLog extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'book_logs';
    protected $fillable = [
        'book_id',
        'borrower_id',
        'librarian_id',
        'is_returned',
        'borrowed_at',
        'returned_at'
    ];
}
