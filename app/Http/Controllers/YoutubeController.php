<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class YoutubeController extends Controller
{
    private $client;
    
    public function __construct()
    {
        $this->client = new \Google_Client();
        $this->client->setApplicationName('Classhub');
        $this->client->setScopes(['https://www.googleapis.com/auth/youtube.upload']);
        $this->client->setAuthConfig([
            'client_id' => env('GOOGLE_OAUTH_CLIENT_ID'),
            'client_secret' => env('GOOGLE_OAUTH_CLIENT_SECRET'),
            'redirect_uris' => ['http://127.0.0.1:8000/google/oauth']
        ]);
        $this->client->setAccessType('online');
    }
    
    public function upload(Request $request)
    {
        try {
            $file = $request->file('video');
    
            // Request authorization from the user.
            $authUrl = $this->client->createAuthUrl();
            printf("Open this link in your browser:\n%s\n", $authUrl);
            print('Enter verification code: ');
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for an access token.
            $accessToken = $this->client->fetchAccessTokenWithAuthCode($authCode);
            $this->client->setAccessToken($accessToken);

            // Define service object for making API requests.
            $service = new \Google_Service_YouTube($this->client);

            // Define the $video object, which will be uploaded as the request body.
            $video = new \Google_Service_YouTube_Video();

            // TODO: For this request to work, you must replace "YOUR_FILE"
            // with a pointer to the actual file you are uploading.
            // The maximum file size for this operation is 137438953472.
            $response = $service->videos->insert(
                '',
                $video,
                array(
                    'data' => file_get_contents($file->getRealPath()),
                    'mimeType' => 'application/octet-stream',
                    'uploadType' => 'multipart'
                )
            );
            dd($response);
        
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        
    }
}
