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
        $this->accountSid = "AC47788ab32f83ef041a156831672c92e8";
        $this->authToken = "64c93fbee40b2aa406ee82cfcbd57978";
        $this->twilioNumber = "+15077095931";
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