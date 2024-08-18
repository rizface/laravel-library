<?php

namespace App\Http\Controllers;

use App\Models\BookLog;
use App\Models\Config;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function ListUserPage() {
        $users = User::where("level", "user")->paginate(20);

        return view("superadmin.listuser", compact('users'));
    }

    public function DeleteUser($id) {
        try {
            $user = User::where("id", $id)->first();
            if ($user == null) {
                Alert::error("Gagal", "Pengguna tidak ditemukan");
                return redirect()->route("page.admin.list_user");
            }

            if ($user->StillBorrowBooks()) {
                Alert::error("Gagal", "Pengguna masih meminjam buku");
                return redirect()->route("page.admin.list_user");
            }

            $user->delete();
            Alert::success("Berhasil", "Pengguna berhasil dihapus");
            return redirect()->route("page.admin.list_user");
        } catch (\Throwable $th) {
            Alert::error("Error", "Something went wrong");
            Log::error($th->getMessage());
            return redirect()->route("page.admin.list_user");
        }
    }

    public function HistoryUser($id) {
        try {
            $config = Config::first();
            $histories = BookLog::where("borrower_id", $id)
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

            return view("superadmin.historyuser", compact('histories'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
            Alert::error("Error", "Something went wrong");
            Log::error($th->getMessage());
            return redirect()->route("page.admin.list_user");
        }
    }
}
