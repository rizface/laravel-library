<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class ConfigController extends Controller
{
    public function ConfigPage() {
        $config = Config::first();
        return view("superadmin.config", compact("config"));
    }

    public function Config(Request $request) {
        try {
            $config = Config::first();
            if (!$config) {
                $config = new Config();
            }
            $config->cost_overdue_per_day = $request->overdue_cost;
            $config->save();

            Alert::success("Sukses", "Pengaturan berhasil disimpan");

            return redirect()->route("page.admin.list_config");
        } catch (\Throwable $th) {
            Alert::error("Error", "Something went wrong");
            Log::error($th);
            return redirect()->back();
        }
    }
}
