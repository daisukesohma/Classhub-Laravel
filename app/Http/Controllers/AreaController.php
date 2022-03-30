<?php

namespace App\Http\Controllers;

use App\Area;
use App\Http\Requests\AreaRequest;
use Illuminate\Http\Request;

class AreaController extends Controller
{

    public function store(AreaRequest $request)
    {
        try {
            Area::create($request->all());

            return response()->json([
                'status' => true,
                'messages' => [\Lang::get('messages.store', [':name' => 'Area'])],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [\Lang::get('messages.error')],
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function update(AreaRequest $request, Area $area)
    {
        try {
            $area->update($request->all());

            return response()->json([
                'status' => true,
                'messages' => [\Lang::get('messages.update', [':name' => 'Area'])],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [\Lang::get('messages.error')],
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function trash(Area $area)
    {
        try {
            $area->delete();

            return response()->json([
                'status' => true,
                'messages' => [\Lang::get('messages.delete', ['name' => 'Area'])]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [\Lang::get('messages.error')],
                'errors' => $e->getMessage()
            ]);
        }
    }
}
