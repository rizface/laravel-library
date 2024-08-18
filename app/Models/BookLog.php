<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        'ended_at',
        'returned_at',
        'overdue',
        'overdue_cost',
        'note'
    ];

    public function GetOverdue() {
        return $this->overdue < 1 ? 0 : $this->overdue;
    }

    public static function BorrowerHistories($borrowerId, $config) {
        return BookLog::where("borrower_id", $borrowerId)
            ->join("books", "books.id", "=", "book_logs.book_id")
            ->join("users", "users.id", "=", "book_logs.borrower_id")
            ->select(
                "books.title",
                DB::raw("book_logs.borrowed_at::date as borrowed_at"),
                DB::raw("book_logs.ended_at::date as ended_at"),
                DB::raw("book_logs.returned_at::date as returned_at"),
                "book_logs.is_returned",
                DB::raw("
                    case 
                        when is_returned = false then date_part('day', now() - ended_at)
                        else overdue
                    end as overdue
                "),
                DB::raw("
                    case
                        when  is_returned = false then date_part('day', now() - ended_at) * $config->cost_overdue_per_day
                        else overdue_cost
                    end as overdue_cost
                "),
                DB::raw("
                    case 
                        when is_returned = false then 'Belum dikembalikan'
                        else 'Sudah dikembalikan'
                    end as status"
                )
            )
            ->paginate(20);
    }

    public static function TotalOverdueCost($borrowerId) {
        return BookLog::where("borrower_id", $borrowerId)->sum("overdue_cost");
    }

    public static function TotalBooks($borrowerId) {
        return BookLog::where("borrower_id", $borrowerId)
        ->select(DB::raw("count(distinct book_id)"))
        ->first()->count;
    }
}
