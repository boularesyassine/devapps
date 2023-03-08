<?php

namespace App\Service;

use Twilio\Rest\Client;

class TwilioService
{

    private $accountSid;
    private $authToken;
    private $twilioNumber;
    private $client;

    public function __construct()
    {
        $this->accountSid = "ACa77f30f369ed17f37db2f73eddb5784d";
        $this->authToken = "9d4c6cbc6cc6f502e38471ebffc2ccd0";
        $this->twilioNumber = "+15076974054";
        $this->client = new Client($this->accountSid, $this->authToken);
    }

    public function sendSms(string $to, string $body)
    {
        $client =new Client( $this->accountSid,  $this->authToken);
        $message= $client->messages->create(
            $to,
            [
                'from' => $this->twilioNumber,
                'body' => $body,
            ]
        );
    }
}