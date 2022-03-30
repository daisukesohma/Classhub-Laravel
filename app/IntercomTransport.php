<?php

namespace App;

use GuzzleHttp\ClientInterface;
use Intercom\IntercomClient;
use Illuminate\Mail\Transport\Transport;

class IntercomTransport extends Transport
{
    protected $client;

    public function __construct($token)
    {
        $this->client = new IntercomClient($token);
    }

    public function send(\Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        $this->beforeSendPerformed($message);

        $options = [];

        $message->setBcc([]);

        $from_email = 'admin@classhub.ie';
        $from_name = 'Classhub';
        $to_email = '';
        $to_name = '';

        foreach ($message->getFrom() as $email => $name) {
            $from_email = $email;
            $from_name = $name;
        }

        foreach ($message->getTo() as $email => $name) {
            $to_email = $email;
            $to_name = $name;
        }

        try {
            $data = [
                "message_type" => "email",
                "subject" => $message->getSubject(),
                "body" => $message->getBody(),
                "from" => [
                    "type" => "admin",
                    "id" => 3081065
                    // use client->getAdmins() to list ids
                ],
                "to" => [
                    "type" => "user",
                    "email" => $to_email
                ]
            ];

            $response = $this->client->messages->create($data);
        } catch (\Exception $e) {
            \Log::info($e);
        }
        return true;
    }
}
