<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCategories;
use App\Models\BookLog;
use App\Models\Category;
use App\Models\Config;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use RealRashid\SweetAlert\Facades\Alert;

class BookController extends Controller
{
    public function AddBookPage() {
        $categories = Category::all();
        return view("superadmin.addbook", compact("categories"));
    }

    public function AddBook(Request $request) {
        try {
            $request->validate([
                "title" => ["required"],
                "qty" => ["required", "gt:0"],
                "author" => ["required"],
                "publisher" => ["required"],
                "isbn" => ["required"],
                "release_date" => ["required", "date"],
                "categories" => ["required"]
            ]);

            if (Book::IsISBNExists($request->isbn)) {
                Alert::error("Gagal", "ISBN sudah digunakan");
                return back();
            }

            $book = Book::create([
                "title" => $request->title,
                "qty" => $request->qty,
                "author" => $request->author,
                "publisher" => $request->publisher,
                "isbn" => $request->isbn,
                "release_date" => $request->release_date
            ]);

            $bookCategories = [];
            foreach ($request->categories as $category) {
                $bookCategories[] = [
                    "id" => Uuid::uuid4(),
                    "book_id" => $book->id,
                    "category_id" => $category,
                    "created_at" => now(),
                    "updated_at" => now()
                ];
            }

            BookCategories::insert($bookCategories);

            Alert::success("Sukses", "Buku berhasil ditambahkan");

            return redirect()->route("page.admin.add_book");
        } catch (\Throwable $th) {
            Alert::error("Error", "Something went wrong");
            Log::error($th->getMessage());
            return back();
        }
    }

    public function GetList() {
        $books = Book::paginate(20);
        return view("superadmin.listbook", compact("books"));
    }

    public function DeleteBook($id) {
        try {
            $book = Book::where("id", $id)->first();
            if (!$book) {
                Alert::error("Gagal", "Buku tidak ditemukan");
                return back();
            }

            if ($book->IsStillBorrowed()) {
                Alert::error("Gagal", "Buku masih dipinjam");
                return back();
            }

            $book->delete();

            Alert::success("Sukses", "Buku berhasil dihapus");
            return back();
        } catch (\Throwable $th) {
            Alert::error("Error", "Something went wrong");
            Log::error($th->getMessage());
            return back();
        }
    }

    public function EditBookPage($id) {
        try {
            if (!Book::IsExists($id)) {
                Alert::error("Gagal", "Buku tidak ditemukan");
                return back();
            }

            $book = Book::where("id", $id)->first();
            $categories = Category::all();

            return view("superadmin.editbook", compact("book", "categories"));
        } catch (\Throwable $th) {
            Alert::error("Error", "Something went wrong");
            Log::error($th->getMessage());
            return back();
        }
    }

    public function EditBook(Request $request, $id) {
        try {
            $request->validate([
                "title" => ["required"],
                "qty" => ["required", "gt:0"],
                "author" => ["required"],
                "publisher" => ["required"],
                "isbn" => ["required"],
                "release_date" => ["required", "date"],
                "categories" => ["required"]
            ]);

            $book = Book::where("id", $id)->first();
            if (!$book) {
                Alert::error("Gagal", "Buku tidak ditemukan");
                return back();
            }

            if ($book->isbn != $request->isbn && Book::IsISBNExists($request->isbn)) {
                Alert::error("Gagal", "ISBN sudah digunakan");
                return back();
            }

            $book->update([
                "title" => $request->title,
                "qty" => $request->qty,
                "author" => $request->author,
                "publisher" => $request->publisher,
                "isbn" => $request->isbn,
                "release_date" => $request->release_date
            ]);

            BookCategories::where("book_id", $book->id)->delete();

            $bookCategories = [];
            foreach ($request->categories as $category) {
                $bookCategories[] = [
                    "id" => Uuid::uuid4(),
                    "book_id" => $book->id,
                    "category_id" => $category,
                    "created_at" => now(),
                    "updated_at" => now()
                ];
            }

            BookCategories::insert($bookCategories);

            Alert::success("Sukses", "Buku berhasil diubah");

            return back();
        } catch (\Throwable $th) {
            Alert::error("Error", "Something went wrong");
            Log::error($th->getMessage());
            return back();
        }
    }

    public function BorrowBookPage() {
        try {
            $users = User::where("level", "user")->get();
            $books = Book::where("qty", ">", 0)->get();

            return view("superadmin.borrowbook", compact("users", "books"));
        } catch (\Throwable $th) {
            Alert::error("Error", "Something went wrong");
            Log::error($th->getMessage());
            return back();
        }
    }

    public function BorrowBook(Request $request) {
        try {
            $request->validate([
                "borrower_id" => ["required", "uuid"],
                "book_id" => ["required", "uuid"],
                "start_date" => ["required", "date"],
                "end_date" => ["required", "date"]
            ]);

            $book = Book::where("id", $request->book_id)->first();
            if (!$book) {
                Alert::error("Gagal", "Buku tidak ditemukan");
                return back();
            }

            if ($book->qty <= 0) {
                Alert::error("Gagal", "Buku habis");
                return back();
            }

            $borrower = User::where("id", $request->borrower_id)->first();
            if (!$borrower) {
                Alert::error("Gagal", "Peminjam tidak ditemukan");
                return back();
            }

            $book->qty -= 1;
            $book->save();

            BookLog::create([
                'book_id' => $book->id,
                'borrower_id' => $borrower->id,
                'librarian_id' => Auth::user()->id,
                'is_returned' => false,
                'borrowed_at' => $request->start_date,
                "ended_at" => $request->end_date,
                "overdue"  => 0,
                "overdue_cost" => 0,
                "note" => "",
                'returned_at' => null
            ]);

            Alert::success("Sukses", "Buku berhasil dipinjam");

            return back();
        } catch (\Throwable $th) {
            dd($th->getMessage());
            Alert::error("Error", "Something went wrong");
            Log::error($th->getMessage());
            return back();
        }
    }

    public function BorrowBookList() {
        try {
            $list = BookLog::join("books", "books.id", "=", "book_logs.book_id")
            ->join("users", "users.id", "=", "book_logs.borrower_id")
            ->select(
                "book_logs.id as log_id",
                "books.id as book_id",
                "users.id as borrower_id",
                "books.title as book_title",
                DB::raw("concat(users.firstname, ' ', users.lastname) as borrower_name"),
                DB::raw("book_logs.borrowed_at::date as borrowed_at"),
                DB::raw("book_logs.ended_at::date as ended_at"),
                DB::raw("date_part('day', now() - book_logs.ended_at) as overdue")
            )
            ->where("book_logs.is_returned", false)
            ->paginate(20);

            $config = Config::first();

            return view("superadmin.listborrowbook", compact("list", "config"));
        } catch (\Throwable $th) {
            Alert::error("Error", "Something went wrong");
            Log::error($th->getMessage());
            return back();
        }
    }

    public function ReturnBookPage(Request $request, $id) {
        try {
            $log = BookLog::join("books", "books.id", "=", "book_logs.book_id")
            ->join("users", "users.id", "=", "book_logs.borrower_id")
            ->select(
                "book_logs.id as log_id",
                "books.id as book_id",
                "users.id as borrower_id",
                "books.title as book_title",
                DB::raw("concat(users.firstname, ' ', users.lastname) as borrower_name"),
                DB::raw("book_logs.borrowed_at::date as borrowed_at"),
                DB::raw("book_logs.ended_at::date as ended_at"),
                DB::raw("date_part('day', now() - book_logs.ended_at) as overdue")
            )
            ->where("book_logs.id", $id)
            ->first();
            if (!$log) {
                Alert::error("Gagal", "Data peminjaman tidak ditemukan");
                return back();
            }

            $config = Config::first();

            return view("superadmin.returnbook", compact("log", "config"));
        } catch (\Throwable $th) {
            Alert::error("Error", "Something went wrong");
            Log::error($th->getMessage());
            return back();
        }
    }

    public function ReturnBook(Request $request, $id) {
        try {
            $log = BookLog::where("id", $id)
            ->select(
                "id",
                "book_id",
                "borrower_id",
                "librarian_id",
                "is_returned",
                "borrowed_at",
                "ended_at",
                "returned_at",
                DB::raw("date_part('day', now() - book_logs.ended_at) as overdue_days")
            )
            ->first();
            if (!$log) {
                Alert::error("Gagal", "Data peminjaman tidak ditemukan");
                return back();
            }

            $book = Book::where("id", $log->book_id)->first();
            if (!$book) {
                Alert::error("Gagal", "Buku tidak ditemukan");
                return back();
            }

            $book->qty += 1;
            $book->save();

            $config = Config::first();
            $overdue = $log->overdue_days < 0 ? 0 : intval($log->overdue_days);

            $log->is_returned = true;
            $log->overdue = $overdue;
            $log->overdue_cost = $overdue * $config->cost_overdue_per_day;
            $log->returned_at = now();
            $log->note = $request->note;
            $log->save();

            Alert::success("Sukses", "Buku berhasil dikembalikan");

            return redirect()->route("page.admin.borrow_list");
        } catch (\Throwable $th) {
            Alert::error("Error", "Something went wrong");
            Log::error($th->getMessage());
            return back();
        }
    }
}
