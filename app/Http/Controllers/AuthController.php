<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function RegisterPage(Request $request) {
        return view("register");
    }

    public function Register(Request $request) {
        $request->validate([
            "firstname" => ["required"],
            "nim" => ["required"],
            "password" => ["required", "confirmed", "min:8"],
            "password_confirmation" => ["required", "min:8"]
        ]);

        $exists = User::where("id_num", $request->nim)->count() > 0;
        if ($exists) {
            Alert::error("Error", "NIM already registered");
            return redirect()->back();
        }

        User::create([
            "id_num" => $request->nim,
            "firstname" => $request->firstname,
            "lastname" => $request->lastname ?? "",
            "password" => Hash::make($request->password),
            "is_active" => false,
            "activate_at" => null
        ]);

        return redirect()->route("page.login");
    }

    public function LoginPage(Request $request) {
        return view("login");
    }

    public function Login(Request $request) {
        $request->validate([
            "id_num" => ["required"],
            "password" => ["required", "min:8"]
        ]);

        $user = User::where("id_num", $request->id_num)->first();
        if (!$user) {
            Alert::error("Error", "NIM / NIP not registered");
            return redirect()->back();
        }

        if (!$user->is_active) {
            Alert::error("Error", "User is not active");
            return redirect()->back();
        }

        Auth::attempt([
            "id_num" => $request->id_num,
            "password" => $request->password
        ]);

        if ($user->level == "superadmin") {
            return redirect()->route("page.admin.list_book");
        }

        return redirect()->route("page.user.dashboard"); 
    }

    public function Logout() {
        Auth::logout();
        return redirect()->route("page.login");
    }
}
