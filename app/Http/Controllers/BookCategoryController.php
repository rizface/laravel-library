<?php

namespace App\Http\Controllers;

use App\Models\BookCategory;
use App\Models\Category;
use Illuminate\Http\Request;
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
}
