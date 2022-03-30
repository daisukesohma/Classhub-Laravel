<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class SettingController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->settings as $key => $value) {
                if ($setting = Setting::where('name', $key)->first()) {
                    $setting->update(['value' => $value]);
                } else {
                    Setting::create(['name' => $key, 'value' => $value]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'messages' => [Lang::get('messages.setting.update')]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error')],
                'errors' => $e->getMessage()
            ]);
        }
    }

}
