<?php

namespace App\Http\Controllers;

use App\Image;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    
    public function upload(Request $request, $folder)
    {
        $input = Input::all();
        $fileUpload = $input['file'];
        
        try {
            Storage::disk('public')->makeDirectory('uploads/' . $folder);
            $fileName = uniqid() . '.' . $fileUpload->getClientOriginalExtension();
            
            if (substr($fileUpload->getMimeType(), 0, 5) == 'image') {
                $file = \Intervention\Image\Facades\Image::make($fileUpload);
                $file->orientate();
                $path = storage_path() . '/app/public/uploads/' . $folder . '/' . $fileName;
                $file->save($path);
            } else {
                $path = str_replace('public/', '', $fileUpload->storeAs('public/uploads/' . $folder, $fileName));
            }
            
            $image = Image::create([
                'title' => $fileUpload->getClientOriginalName(),
                'path' => 'uploads/' . $folder . '/' . $fileName
            ]);
            
            return response()->json([
                'status' => true,
                'id' => $image->id,
                'title' => $image->title,
                'path' => $image->path,
                'storage_path' => Storage::url($image->path)
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'code' => 500,
                'error' => $e->getMessage(),
            ]);
        }
    }
    
    public function delete($id)
    {
        try {
            $image = Image::findOrFail($id);
            
            $result = Storage::disk('public')->delete($image->path);
            
            if ($result) {
                $image->delete();
            }
            
            return response()->json([
                'status' => $result,
                'messages' => [$result ? 'Image deleted' : Lang::get('messages.error')]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('messages.error'), $e->getMessage()]
            ]);
        }
    }
    
}
