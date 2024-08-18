<?php

namespace App\Http\Controllers;

use App\Models\BookLog;
use App\Models\Config;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function ListUserPage() {
        $users = User::where("level", "user")->paginate(20);

        return view("superadmin.listuser", compact('users'));
    }

    public function ListAdminPage() {
        $users = User::where("level", "superadmin")->paginate(20);

        return view("superadmin.listadmin", compact('users'));
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
            $histories = BookLog::BorrowerHistories($id, $config);
            $totalOverdueCost = "Rp.".number_format(BookLog::TotalOverdueCost($id), 0, ",", ".");
            $totalBooks = BookLog::TotalBooks($id);

            return view("superadmin.historyuser", compact('histories', 'totalOverdueCost', 'totalBooks'));
        } catch (\Throwable $th) {
            Alert::error("Error", "Something went wrong");
            Log::error($th->getMessage());
            return redirect()->route("page.admin.list_user");
        }
    }

    public function AddUserPage() {
        return view("superadmin.adduser");
    }

    public function AddUser(Request $request) {
        try {
            $request->validate([
                "firstname" => ["required"],
                "id_num" => ["required"],
                "level" => ["required"],
                "password" => ["required", "min:8"]
            ]);

            if (User::IsIdNumTaken($request->id_num)) {
                Alert::error("Gagal", "Nomor Identitas sudah digunakan");
                return redirect()->route("page.admin.add_user");
            } 

            User::create([
                "firstname" => $request->firstname,
                "lastname" => $request->lastname,
                "id_num" => $request->id_num,
                "level" => $request->level,
                "password" => Hash::make($request->password),
                "is_active" => true
            ]);

            Alert::success("Berhasil", "Pengguna berhasil ditambahkan");

            if ($request->level == "user") {
                return redirect()->route("page.admin.list_user");
            }
            
            return redirect()->route("page.admin.list_admin");
        } catch (\Throwable $th) {
            Alert::error("Error", "Something went wrong");
            Log::error($th->getMessage());
            return redirect()->route("page.admin.list_user");
        }
    }

    public function ProfilePage() {
        try {
            $authUser = Auth::user();
            $profile = [
                "firstname" => $authUser->firstname,
                "lastname" => $authUser->lastname,
                "id_num" => $authUser->id_num
            ];
    
            return view("superadmin.profile", compact('profile'));
        } catch (\Throwable $th) {
            Alert::error("Error", "Something went wrong");
            Log::error($th->getMessage());
            return redirect()->route("page.admin.list_user");
        }
    }

    public function UpdateProfile(Request $request) {
        try {
            $request->validate([
                "firstname" => ["required"],
                "id_num" => ["required"],
            ]);

            $user = User::where("id", Auth::user()->id)->first();
            if (!$user) {
                Alert::error("Gagal", "Pengguna tidak ditemukan");
                return redirect()->route("page.admin.profile");
            }

            if ($user->id_num != $request->id_num && User::IsIdNumTaken($request->id_num)) {
                Alert::error("Gagal", "Nomor Identitas sudah digunakan");
                return redirect()->route("page.admin.profile");
            }

            $user->update([
                "firstname" => $request->firstname,
                "lastname" => $request->lastname,
                "id_num" => $request->id_num,
            ]);

            Alert::success("Berhasil", "Profil berhasil diperbarui");
            return redirect()->route("page.admin.profile");
        } catch (\Throwable $th) {
            Alert::error("Error", "Something went wrong");
            Log::error($th->getMessage());
            return redirect()->route("page.admin.profile");
        }
    }

    public function UserDashboardPage() {
        try {
            $config = Config::first();
            $user = Auth::user();
            $id = $user->id;
            $histories = BookLog::BorrowerHistories($id, $config);
            $totalOverdueCost = "Rp.".number_format(BookLog::TotalOverdueCost($id), 0, ",", ".");
            $totalBooks = BookLog::TotalBooks($id);

            return view("user.historyuser", compact('histories', 'totalOverdueCost', 'totalBooks'));
        } catch (\Throwable $th) {
            Alert::error("Error", "Something went wrong");
            Log::error($th->getMessage());
            return redirect()->route("page.user.dashboard");
        }
    }
}
