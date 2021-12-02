<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayMongo extends Model
{
    use HasFactory;
    
    private $authorization = 'Basic cGtfdGVzdF9EblR5WHlLWmF1YkZyWFRKRVc1QWZwR3M6c2tfdGVzdF9KaFpNdWplMmV1a0toQ1VpN1Zka0RNRzY=';

    public function createPaymayaPaymentMethod() {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://api.paymongo.com/v1/payment_methods', [
            'body' => '{"data":{"attributes":{"type":"paymaya"}}}',
            'headers' => [
              'Accept' => 'application/json',
              'Authorization' => 'Basic c2tfdGVzdF9KaFpNdWplMmV1a0toQ1VpN1Zka0RNRzY6cGtfdGVzdF9EblR5WHlLWmF1YkZyWFRKRVc1QWZwR3M=',
              'Content-Type' => 'application/json',
            ],
          ]);
          
          return  json_decode($response->getBody());
    }

    public function createPaymayaPaymentIntent($amount) {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://api.paymongo.com/v1/payment_intents', [
          'body' => '{"data":{"attributes":{"amount":'.$amount.',"payment_method_allowed":["card","paymaya"],"payment_method_options":{"card":{"request_three_d_secure":"any"}},"currency":"PHP"}}}',
          'headers' => [
            'Accept' => 'application/json',
            'Authorization' => 'Basic c2tfdGVzdF9KaFpNdWplMmV1a0toQ1VpN1Zka0RNRzY6cGtfdGVzdF9EblR5WHlLWmF1YkZyWFRKRVc1QWZwR3M=',
            'Content-Type' => 'application/json',
          ],
        ]);

        return  json_decode($response->getBody());
    }

    public function attatchPaymayaPaymentIntent($payment_intent_id, $payment_method_id) {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://api.paymongo.com/v1/payment_intents/'.$payment_intent_id.'/attach', [
            'body' => '{
              "data":{
                "attributes":
                {
                  "payment_method":"'.$payment_method_id.'",
                  "return_url":"'.route('createPayment').'"
                }
              }
            }',
            'headers' => [
              'Accept' => 'application/json',
              'Authorization' => 'Basic c2tfdGVzdF9KaFpNdWplMmV1a0toQ1VpN1Zka0RNRzY6cGtfdGVzdF9EblR5WHlLWmF1YkZyWFRKRVc1QWZwR3M=',
              'Content-Type' => 'application/json',
            ],
          ]);

        return  json_decode($response->getBody());
    }

    public function getSourceURL($object) {
      return $object->data->attributes->next_action->redirect->url;
    }
    public function getSourceID($object) {
        $url = $this->getSourceURL($object);
        $id_pos = strpos($url,"?id");
        return $url = substr($url, $id_pos+4);
    }

    public function createSource($amount) {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://api.paymongo.com/v1/sources', [
            'body' => '{
                "data":
                {
                    "attributes":
                    {
                        "amount":'.$amount.',
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
        $amount = session()->get('amount');
        $source =  $this->retrieveSource($source_id);

        if (isset($source->data) && isset($source->data->attributes) && isset($source->data->attributes->status) 
            && $source->data->attributes->status == 'chargeable') 
        {
            $client = new \GuzzleHttp\Client();

            $response = $client->request('POST', 'https://api.paymongo.com/v1/payments', [
                'body' => '{"data":{"attributes":{"amount":'.$amount.',"source":{"id":"'.$source->data->id.'","type":"source"},"currency":"PHP"}}}',
                'headers' => [
                  'Accept' => 'application/json',
                  'Authorization' => 'Basic c2tfdGVzdF9KaFpNdWplMmV1a0toQ1VpN1Zka0RNRzY6cGtfdGVzdF9EblR5WHlLWmF1YkZyWFRKRVc1QWZwR3M=',
                  'Content-Type' => 'application/json',
                ],
              ]);
              
            $payment_info = json_decode($response->getBody());
            
            if ($payment_info->data->attributes->status == 'paid') {
                return redirect('/order-info/'.$source->data->id.'/gcash')->with('success', 'Order recieved, your payment ₱'.($amount/100).' via GCash was successful!');
            }
            else {
                return response()->json([
                    'status' =>  'error',
                    'message' => 'Payment failed'
                ], 200);
            }
        }
        else if ($source->data->attributes->type == 'paymaya' && $source->data->attributes->status == 'consumed'){
          return redirect('/order-info/'.$source->data->id.'/'.$source->data->attributes->type)->with('success', 'Order recieved, your payment ₱'.($amount/100).' via PayMaya was successful!');
        }
        else {
          return response()->json([
              'status' =>  'error',
              'message' => 'Payment failed'
          ], 200);
        }
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
