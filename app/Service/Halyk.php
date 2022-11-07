<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;

class Halyk
{
    const clientId = 'test';
    const terminalId = '67e34d63-102f-4bd1-898e-370781d0074d';
    const clientSecret = 'yF587AV9Ms94qN2QShFzVR3vFnWkhjbAK3sG';
    const terminal = '98025601';

    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function token()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
//            CURLOPT_URL => 'https://epay-oauth.homebank.kz/oauth2/token',         prod
            CURLOPT_URL => 'https://testoauth.homebank.kz/epay2/oauth2/token',           //test
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'grant_type' => 'client_credentials',
                'scope' => "webapi usermanagement email_send verification statement statistics payment",
                'client_id' => self::clientId,
                'client_secret' => self::clientSecret,
                'invoiceID' => $this->data['invoice_id'],
                'amount' => $this->data['amount'],
                'currency' => 'KZT',
                'terminal' => self::terminalId,
                'postLink' => '',
                'failurePostLink' => ''),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}
