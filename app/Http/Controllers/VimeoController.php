<?php

namespace App\Http\Controllers;

use App\Helpers\ClassHubHelper;
use App\LessonClass;
use App\Jobs\VimeoTrimJob;
use Illuminate\Http\Request;
use Vimeo\Exceptions\VimeoRequestException;
use Vimeo\Exceptions\VimeoUploadException;
use Vimeo\Vimeo;

class VimeoController extends Controller
{
    public function upload(Request $request)
    {
        try {
            $video = $request->file('video');
            
            try {
                $vimeo = new Vimeo(env('VIMEO_ID'), env('VIMEO_SECRET'), env('VIMEO_TOKEN'));
                
                $name = str_replace('.' . $video->getClientOriginalExtension(), '', $video->getClientOriginalName());
                $name = str_replace('_', ' ', $name);

                $uri = $vimeo->upload($video->getRealPath(), [
                    'name' => $name
                ]);

                if ($request->get('trim') !== null) {
                    VimeoTrimJob::dispatch($uri, 0, $request->get('trim'))->delay(now()->addMinutes(20));
                }
    
                $vimeo->request($uri.'/privacy/domains/'.parse_url(route('home'))['host'], [], 'PUT');
                
                $vimeo->request($uri, [
                    'privacy' => [
                        'view' => 'disable',
                        'embed' => 'whitelist',
                        'download' => false
                    ],
                ], 'PATCH');
                
                $videoData = $vimeo->request($uri . '?field=link');
                $pathArr = explode('/', parse_url($videoData['body']['link'], PHP_URL_PATH));
                $id = $pathArr[count($pathArr) - 1];
                
                return response()->json([
                    'status' => true,
                    'message' => 'Video added successfully.',
                    'id' => $id,
                    'name' => $name,
                    'delete_url' => route('vimeo.delete', $id),
                    'response' => $videoData
                ]);
                
            } catch (VimeoUploadException $e) {
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage(),
                    'errors' => $e->getTrace()
                ]);
            } catch (VimeoRequestException $e) {
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage(),
                    'errors' => $e->getTrace()
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'errors' => $e->getTrace()
            ]);
        }
        
    }
    
    
    public function reUpload(Request $request)
    {
        try {
            $video = $request->file('video');
            $class = LessonClass::whereId($request->id)->first();
            
            try {
                $vimeo = new Vimeo(env('VIMEO_ID'), env('VIMEO_SECRET'), env('VIMEO_TOKEN'));
                
                $uri = $vimeo->upload($video->getRealPath(), []);
                $name = str_replace('.' . $video->getClientOriginalExtension(), '', $video->getClientOriginalName());
                $name = str_replace('_', ' ', $name);
    
                $vimeo->request($uri.'/privacy/domains/'.parse_url(route('home'))['host'], [], 'PUT');
    
                $vimeo->request($uri, [
                    'name' => $name,
                    'privacy' => [
                        'view' => 'disable',
                        'embed' => 'whitelist',
                        'download' => false
                    ],
                ], 'PATCH');
                
                $videoData = $vimeo->request($uri . '?field=link');
                $pathArr = explode('/', parse_url($videoData['body']['link'], PHP_URL_PATH));
                $id = $pathArr[count($pathArr) - 1];
                
                $class->update([
                    'video_id' => $id,
                    'video_name' => $name,
                    'video_status' => 'in_progress'
                ]);
                
                return response()->json([
                    'status' => true,
                    'message' => 'Video added successfully.',
                    'id' => $id,
                    'name' => $name,
                    'delete_url' => route('vimeo.delete', $id),
                    'response' => $videoData
                ]);
                
            } catch (VimeoUploadException $e) {
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage(),
                    'errors' => $e->getTrace()
                ]);
            } catch (VimeoRequestException $e) {
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage(),
                    'errors' => $e->getTrace()
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'errors' => $e->getTrace()
            ]);
        }
        
    }
    
    
    public function delete($videoId)
    {
        try {
            $vimeo = new Vimeo(env('VIMEO_ID'), env('VIMEO_SECRET'), env('VIMEO_TOKEN'));
            
            $vimeo->request('/videos/' . $videoId, [], 'DELETE');
        } catch (\Exception $e) {
            dump($e->getMessage());
        }
    }
}
