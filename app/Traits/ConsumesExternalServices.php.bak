<?php

namespace App\Traits;

use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

trait ConsumesExternalServices
{

    public function GenerarToken()
    {

        // $clientID = config('services.paypal.client_id');
        // $clientSecret = config('services.paypal.client_secret');
        // $baseUri = config('services.paypal.base_uri');

        $client = new Client();

        $options = [
            RequestOptions::HEADERS => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            RequestOptions::FORM_PARAMS => [
                'grant_type' => 'client_credentials',
            ],
            RequestOptions::AUTH => [
                $this->clientId, $this->clientSecret
            ]
        ];
        $response = $client->post($this->baseUri . '/v1/oauth2/token', $options);

        $data = json_decode($response->getBody(), true);
        $token = $data['access_token'];

        return 'Bearer ' . $token;
    }

    public function ListarPlanes()
    {

        $client = new Client();

        $headers = [
            'Authorization' => $this->GenerarToken(),
            'Content-Type' => 'application/json',
        ];

        $url = $this->baseUri . '/v1/billing/plans';

        $response = $client->get($url, ['headers' => $headers]);

        $data = json_decode($response->getBody(), true);

        return  $data;
    }



    public function Suscribirse($planSeleccionado, User $user)
    {

        $client = new Client();

        $headers = [
            'Authorization' => $this->GenerarToken(),
            'Content-Type' => 'application/json',
        ];

        $body = [
            "plan_id" => $planSeleccionado,
            "custom_id" => uniqid() . "_" . $user->name,
            "subscriber" => [
                "name" => [
                    "given_name" => $user->name
                ],
                "email_address" => $user->email
            ],
            "application_context" => [
                "brand_name" => "LEARNSTREAM",
                "locale" => "es-ES",
                "shipping_preference" => "NO_SHIPPING",
                "user_action" => "SUBSCRIBE_NOW",
                "return_url" => route('usuarios'),
                "cancel_url" => route('usuarios'),
            ]
        ];

        $url = $this->baseUri . '/v1/billing/subscriptions';

        $jsonBody = json_encode($body, JSON_UNESCAPED_SLASHES);

        $response = $client->post($url, ['headers' => $headers, 'body' => $jsonBody]);

        $data = json_decode($response->getBody(), true);


        if (isset($data['links'])) {
            foreach ($data['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    $urlAprobacion = $link['href'];
                }
            }
        }

        return $urlAprobacion;
    }
}
