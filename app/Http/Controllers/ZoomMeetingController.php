<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Firebase\JWT\JWT;
use Log;

class ZoomMeetingController extends Controller
{
    public $client;
    public $jwt;
    public $headers;

    public function __construct()
    {
        $this->client = new Client();
        $this->jwt = $this->generateZoomToken();
        $this->headers = [
            'Authorization' => 'Bearer '.$this->jwt,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];
    }

    public function generateZoomToken()
    {
        $key = env('ZOOM_API_KEY', '');
        $secret = env('ZOOM_API_SECRET', '');
        $payload = [
            'iss' => $key,
            'exp' => strtotime('+1 minute'),
        ];

        return JWT::encode($payload, $secret, 'HS256');
    }

    private function retrieveZoomUrl()
    {
        return env('ZOOM_API_URL', '');
    }

    public function toZoomTimeFormat(string $dateTime)
    {
        try {
            $date = new \DateTime($dateTime);

            return $date->format('Y-m-d\TH:i:s');
        } catch (\Exception $e) {
            Log::error('ZoomJWT->toZoomTimeFormat : '.$e->getMessage());

            return '';
        }
    }

    public function getMeetingIdFromLink(string $link)
    {
        $link_array = explode('/', $link);
        $end = end($link_array);
        $id_array = explode('?', $end);
        
        return current($id_array);
    }

    public function create($data, $userId = 'me')
    {
        try {
            $path = 'users/'.$userId.'/meetings';
            $url = $this->retrieveZoomUrl();
            $body = [
                'headers' => $this->headers,
                'body'    => json_encode([
                    'topic'            => $data['topic'],
                    'agenda'           => (!empty($data['agenda'])) ? $data['agenda'] : null,
                    'type'             => 2,
                    'start_time'       => $this->toZoomTimeFormat($data['start_time']),
                    'duration'         => $data['duration'],
                    'timezone'         => 'Europe/Dublin',
                    'default_password' => true,
                    'settings'   => [
                        'host_video'        => false,
                        'participant_video' => false,
                        'join_before_host'  => true,
                        'auto_recording'    => 'local',
                    ],
                ]),
            ];
    
            $response =  $this->client->post($url.$path, $body);
    
            return [
                'success' => $response->getStatusCode() === 201,
                'data'    => json_decode($response->getBody(), true),
            ];
        } catch (\Exception $e) {
            Log::error('ZoomJWT->create : '.$e->getMessage());

            return [
                'success' => false,
                'errors' => $e->getMessage(),
            ];
        }
    }

    public function update($link, $data)
    {
        try {
            $path = 'meetings/'.$this->getMeetingIdFromLink($link);
            $url = $this->retrieveZoomUrl();
            $body = [
                'headers' => $this->headers,
                'body'    => json_encode([
                    'topic'      => $data['topic'],
                    'start_time' => $this->toZoomTimeFormat($data['start_time']),
                    'duration'   => $data['duration'],
                    'agenda'     => (! empty($data['agenda'])) ? $data['agenda'] : null,
                ]),
            ];

            $response =  $this->client->patch($url.$path, $body);
    
            return [
                'success' => $response->getStatusCode() === 204,
                'data'    => json_decode($response->getBody(), true),
            ];
        } catch (\Exception $e) {
            Log::error('ZoomJWT->update : '.$e->getMessage());

            return [
                'success' => false,
                'errors' => $e->getMessage(),
            ];
        }
    }

    public function get($link)
    {
        try {
            $path = 'meetings/'.$this->getMeetingIdFromLink($link);
            $url = $this->retrieveZoomUrl();
            $this->jwt = $this->generateZoomToken();
            $body = [
                'headers' => $this->headers,
                'body'    => json_encode([]),
            ];
    
            $response =  $this->client->get($url.$path, $body);
    
            return [
                'success' => $response->getStatusCode() === 200,
                'data'    => json_decode($response->getBody(), true),
            ];
        } catch (\Exception $e) {
            Log::error('ZoomJWT->get : '.$e->getMessage());

            return [
                'success' => false,
                'errors' => $e->getMessage(),
            ];
        }
    }

    public function delete($link)
    {
        try {
            $path = 'meetings/'.$this->getMeetingIdFromLink($link);
            $url = $this->retrieveZoomUrl();
            $body = [
                'headers' => $this->headers,
                'body'    => json_encode([]),
            ];
    
            $response =  $this->client->delete($url.$path, $body);
    
            return [
                'success' => $response->getStatusCode() === 204,
            ];
        } catch (\Exception $e) {
            Log::error('ZoomJWT->delete : '.$e->getMessage());

            return [
                'success' => false,
                'errors' => $e->getMessage(),
            ];
        }
    }

    public function updateMeetingStatus($link, $status)
    {
        try {
            $path = 'meetings/'.$this->getMeetingIdFromLink($link).'/status';
            $url = $this->retrieveZoomUrl();
            $this->jwt = $this->generateZoomToken();
            $body = [
                'headers' => $this->headers,
                'body'    => json_encode([
                    'action' => $status
                ]),
            ];
    
            $response =  $this->client->put($url.$path, $body);
    
            return [
                'success' => $response->getStatusCode() === 204,
                'data'    => json_decode($response->getBody(), true),
            ];
        } catch (\Exception $e) {
            Log::error('ZoomJWT->updateMeetingStatus : '.$e->getMessage());

            return [
                'success' => false,
                'errors' => $e->getMessage(),
            ];
        }
    }

    public function listMeetingParticipants($meetingId)
    {
        try {
            $path = 'metrics/meetings/'.$meetingId.'/participants';
            $url = $this->retrieveZoomUrl();
            $this->jwt = $this->generateZoomToken();
            $body = [
                'headers' => $this->headers,
                'body'    => json_encode([
                    'type' => 'live'
                ]),
            ];
    
            $response =  $this->client->get($url.$path, $body);
    
            return [
                'success' => $response->getStatusCode() === 200,
                'data'    => json_decode($response->getBody(), true),
            ];
        } catch (\Exception $e) {
            Log::error('ZoomJWT->listMeetingParticipants : '.$e->getMessage());

            return [
                'success' => false,
                'errors' => $e->getMessage(),
            ];
        }
    }

    public function createUser($data)
    {
        try {
            $path = 'users';
            $url = $this->retrieveZoomUrl();
            $body = [
                'headers' => $this->headers,
                'body'    => json_encode([
                    'action'      => 'custCreate',
                    'user_info'   => [
                        'email'        => $data['email'],
                        'type'         => 2,
                        'first_name'   => $data['first_name'],
                        'last_name'    => $data['last_name'],
                    ],
                ]),
            ];
    
            $response =  $this->client->post($url.$path, $body);
    
            return [
                'success' => $response->getStatusCode() === 201,
                'data'    => json_decode($response->getBody(), true),
            ];
        } catch (\Exception $e) {
            Log::error('ZoomJWT->createUser : '.$e->getMessage());

            return [
                'success' => false,
                'errors' => json_decode($e->getMessage(), true),
            ];
        }
    }

    public function deleteUser($userId)
    {
        try {
            $path = 'users/'.$userId;
            $url = $this->retrieveZoomUrl();
            $body = [
                'headers' => $this->headers,
                'body'    => json_encode([]),
            ];
    
            $response =  $this->client->delete($url.$path, $body);
    
            return [
                'success' => $response->getStatusCode() === 204,
            ];
        } catch (\Exception $e) {
            Log::error('ZoomJWT->deleteUser : '.$e->getMessage());

            return [
                'success' => false,
                'errors' => $e->getMessage(),
            ];
        }
    }
}
