<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;



/**
 * @property ArticleRepository $repository
 */
class WiseService
{
    private $wiseApiUrl;
    private $wiseProfile;
    private $wiseApiToken;

    public function __construct()
    {
        $this->wiseApiUrl = Config::get('app.wise_api_url');
        $this->wiseProfile = Config::get('app.wise_profile');
        $this->wiseApiToken = Config::get('app.wise_api_token');
    }

    public function create_quote($quote)
    {

        $response = Http::withHeaders([
            "Authorization" => "Bearer " . $this->wiseApiToken,
        ])->post($this->wiseApiUrl . "/v1/quotes", $quote);

        return $response->json();
    }


    public function create_recipient($recipient)
    {
        $response = Http::withHeaders([
            "Authorization" => "Bearer " . $this->wiseApiToken,
        ])->post($this->wiseApiUrl . "/v1/accounts", $recipient);

        return $response->json();
    }


    public function create_transfer($transfer)
    {
        if (!isset($transfer['customerTransactionId'])) {
            $customerTransactionId = Http::get('https://www.uuidgenerator.net/api/guid');
            $transfer['customerTransactionId'] = $customerTransactionId->body();
        }

        $response = Http::withHeaders([
            "Authorization" => "Bearer " . $this->wiseApiToken,
        ])->post($this->wiseApiUrl . "/v1/transfers", $transfer);

        return $response->json();
    }

    public function fund_transfer_balance($request)
    {
        
        $transferId = null;
        if (isset($request['transferId'])) {
            $transferId = $request['transferId'];
        }

        if(!$transferId){
            return response()->json([
                'status' => 404,
                'message' => trans("Transfer error!"),
                'data' => [],
            ], 404);
        }

        
        $data = ["type" => "BALANCE"];

        $response = Http::withHeaders([
            "Authorization" => "Bearer " . $this->wiseApiToken,
        ])->post($this->wiseApiUrl . "/v3/profiles/" . $this->wiseProfile . "/transfers/". $transferId . "/payments", $data);

        return $response->json();
    }

    public function get_transaction_by_id($transactionId)
    {
        $response = Http::withHeaders([
            "Authorization" => "Bearer " . $this->wiseApiToken,
        ])->get($this->wiseApiUrl . "/v1/transfers/" . $transactionId);

        return $response->json();
    }

    public function balances_by_type($request)
    {
        $type = 'STANDARD';
        if (isset($request['types'])) {
            $type = $request['types'];
        }
        $response = Http::withHeaders([
            "Authorization" => "Bearer " . $this->wiseApiToken,
        ])->get($this->wiseApiUrl . "/v4/profiles/" . $this->wiseProfile . "/balances?types=" . $type);

        return $response->json();
    }

    public function accounts_list($request)
    {
        $currency = 'GBP';
        if (isset($request['currency'])) {
            $currency = $request['currency'];
        }


        /*
        $sourceCurrency = "EUR";
        $targetCurrency = "GBP";
        $sourceAmount = 0;
        $targetAmount = 0;
        $payInMethod = "BALANCE";
        $recentContactsPageSize = 5;
        $contactsPageSize = 8;
        $includeExternalIdentifiers = "true";
        $enriched = "true";

        $ary = [
            'sourceCurrency', 'targetCurrency', 'sourceAmount', 'targetAmount', 'payInMethod', 'recentContactsPageSize', 'contactsPageSize', 'includeExternalIdentifiers', 'enriched'
        ];

        $aryData = [];
        foreach ($ary as $v) {
            if (isset($request[$v])) {
                $aryData[] = "$v=" . $request[$v];
            }
        }
        $strUrl = implode('&', $aryData);
        */

        //$url = $this->wiseApiUrl . "/gateway/v2/profiles/" . $this->wiseProfile . "/accounts-list?" . $strUrl;
        $url = $this->wiseApiUrl . "/v2/accounts?profile=".$this->wiseProfile."&currency=".$currency;
        $response = Http::withHeaders([
            "Authorization" => "Bearer " . $this->wiseApiToken,
        ])->get($url);


        return $response->json();
    }

    public function payment_finishing($request)
    {
        $transferId = null;
        if (isset($request['transferId'])) {
            $transferId = $request['transferId'];
        }

        if(config('app.env') == 'local' || config('app.env') == 'dev') {

            $response = Http::withHeaders([
                "Authorization" => "Bearer " . $this->wiseApiToken,
            ])->get($this->wiseApiUrl . "/v1/simulation/transfers/" . $transferId . "/funds_converted");


            $response = Http::withHeaders([
                "Authorization" => "Bearer " . $this->wiseApiToken,
            ])->get($this->wiseApiUrl . "/v1/simulation/transfers/" . $transferId . "/processing");


            $response = Http::withHeaders([
                "Authorization" => "Bearer " . $this->wiseApiToken,
            ])->get($this->wiseApiUrl . "/v1/simulation/transfers/" . $transferId . "/outgoing_payment_sent");
        } else {
            $data = $request;
            $response = Http::withHeaders([
                "Authorization" => "Bearer " . $this->wiseApiToken,
            ])->post("https://card-form.wise.com/api/v3/card/payment", $data);
            // ])->post("https://card-form.sandbox.transferwise.tech/api/v3/card/payment", $data);
        }

        return $response->json();
    }

    public function get_quote($quoteId)
    {
        $response = Http::withHeaders([
            "Authorization" => "Bearer " . $this->wiseApiToken,
        ])->get( $this->wiseApiUrl . "/v3/profiles/" . $this->wiseProfile . "/quotes/" . $quoteId );

        return $response->json();
    }

    public function get_transfer($transferId)
    {

        $response = Http::withHeaders([
            "Authorization" => "Bearer " . $this->wiseApiToken,
        ])->get( "https://sandbox.transferwise.tech/gateway/v3/profiles/" . $this->wiseProfile . "/transfers/". $transferId );

        return $response->json();
    }
}
