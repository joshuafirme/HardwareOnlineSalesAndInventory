<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayMongo extends Model
{
    use HasFactory;
    
    private $authorization = 'Basic cGtfdGVzdF9EblR5WHlLWmF1YkZyWFRKRVc1QWZwR3M6c2tfdGVzdF9KaFpNdWplMmV1a0toQ1VpN1Zka0RNRzY=';
    
    public function createSource() {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://api.paymongo.com/v1/sources', [
            'body' => '{
                "data":
                {
                    "attributes":
                    {
                        "amount":10000,
                        "redirect":{
                            "success":"'.route('createPayment').'",
                            "failed":"'.route('createPayment').'"
                        },
                        "type":"gcash",
                        "currency":"PHP"
                    }
                }
            }',
            'headers' => [
              'Accept' => 'application/json',
              'Authorization' => $this->authorization,
              'Content-Type' => 'application/json',
            ],
          ]);

          $body = json_decode($response->getBody());
          $source = $body->data->attributes;
          session()->put('source_id', $body->data->id);
          return redirect($source->redirect->checkout_url);
    }

    public function retrieveSource($source_id){
        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', 'https://api.paymongo.com/v1/sources/'.$source_id, [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $this->authorization,
            ],
        ]);
        return json_decode($response->getBody());
    }

    public function createPayment() {
        $source_id = session()->get('source_id');
        $source =  $this->retrieveSource($source_id);
     
        if (isset($source->data) && isset($source->data->attributes) && isset($source->data->attributes->status) 
            && $source->data->attributes->status == 'chargeable') 
        {
            $client = new \GuzzleHttp\Client();

            $response = $client->request('POST', 'https://api.paymongo.com/v1/payments', [
                'body' => '{"data":{"attributes":{"amount":10000,"source":{"id":"'.$source->data->id.'","type":"source"},"currency":"PHP"}}}',
                'headers' => [
                  'Accept' => 'application/json',
                  'Authorization' => 'Basic c2tfdGVzdF9KaFpNdWplMmV1a0toQ1VpN1Zka0RNRzY6cGtfdGVzdF9EblR5WHlLWmF1YkZyWFRKRVc1QWZwR3M=',
                  'Content-Type' => 'application/json',
                ],
              ]);
              
            $payment_info = json_decode($response->getBody());

            if ($payment_info->data->attributes->status == 'paid') {
                return 'success';
                return view('/payment-info')->with('success', 'Payment success!');
            }
            else {
                return response()->json([
                    'status' =>  'error',
                    'message' => 'Payment failed'
                ], 200);
            }
        }
        return response()->json([
            'status' =>  'error',
            'message' => 'Payment failed'
        ], 200);
        
        
    }

    public function retrievePayment($payment_id) {
        $response = $client->request('GET', 'https://api.paymongo.com/v1/payments/'.$payment_id, [
            'headers' => [
              'Accept' => 'application/json',
              'Authorization' => 'Basic c2tfdGVzdF9KaFpNdWplMmV1a0toQ1VpN1Zka0RNRzY6cGtfdGVzdF9EblR5WHlLWmF1YkZyWFRKRVc1QWZwR3M=',
            ],
          ]);
          return json_decode($response->getBody());
    }
}
