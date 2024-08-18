<?php

namespace App\Http\Controllers;

use App\Models\BookCategories;
use App\Models\BookCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class BookCategoryController extends Controller
{
    public function AddCategoryPage() {
        return view("superadmin.addbookcat");
    }

    public function AddCategory(Request $request) {
        try {
            $request->validate([
                "category" => ["required"]
            ]);

            if (Category::CategoryAlreadyExists($request->category)) {
                Alert::error("Error", "Category already exists");
                return back();
            }

            Category::create([
                "name" => strtolower($request->category)
            ]);

            Alert::success("Success", "Category added successfully");

            return redirect()->route("page.admin.add_category");
        } catch (\Throwable $th) {
            Alert::error("Error", "Something went wrong");
            return back();
        }
    }

    public function GetList() {
        $categories = Category::join("book_categories", "categories.id", "=", "book_categories.category_id")
        ->select("categories.id", "categories.name", DB::raw("count(*) as total"))
        ->groupBy("categories.id", "categories.name")
        ->paginate(20);

        return view("superadmin.listbookcat", compact("categories"));
    }

    public function DeleteCategory($id) {
        try {
            $category = Category::find($id);
            if (!$category) {
                Alert::error("Gagal", "Kategori tidak ditemukan");
                return back();
            }
    
            $category->delete();
    
            Alert::success("Sukses", "Category deleted successfully");
    
            return back();
        } catch (\Throwable $th) {
            Alert::error("Error", "Something went wrong");
            Log::error($th->getMessage());
            return back();
        }
    }

    public function EditPageCategory($id) {
        try {
            $category = Category::find($id);
            if (!$category) {
                Alert::error("Gagal", "Kategori tidak ditemukan");
                return back();
            }

            return view("superadmin.editbookcat", compact("category"));
        } catch (\Throwable $th) {
            Alert::error("Error", "Something went wrong");
            Log::error($th->getMessage());
            return back();
        }
    }

    public function EditCategory(Request $request, $id) {
        try {
            $request->validate([
                "category" => ["required"]
            ]);

            $category = Category::find($id);
            if (!$category) {
                Alert::error("Gagal", "Kategori tidak ditemukan");
                return back();
            }

            $category->update([
                "name" => strtolower($request->category)
            ]);

            Alert::success("Sukses", "Kategori berhasil diubah");

            return redirect()->route("page.admin.edit_category", $id);
        } catch (\Throwable $th) {
            Alert::error("Error", "Something went wrong");
            Log::error($th->getMessage());
            return back();
        }
    }

    public function ListBookCategory($id) {
        try {
            $books = BookCategories::join("books", "book_categories.book_id", "=", "books.id")
            ->join("book_logs", "books.id", "=", "book_logs.book_id")
            ->where("book_categories.category_id", $id)
            ->select(
                "books.id",
                "books.isbn",
                "books.title",
                "books.author",
                "books.publisher",
                "books.release_date",
                DB::raw("count(book_logs.id) as total")
            )
            ->groupBy("books.id", "books.isbn", "books.title", "books.author", "books.publisher", "books.release_date")
            ->orderBy("total", "desc")
            ->paginate(20);

            return view("superadmin.listcatbooks", compact("books"));
        } catch (\Throwable $th) {
            Alert::error("Error", "Something went wrong");
            Log::error($th->getMessage());
            return back();
        }
    }
}
