<?php


class PayStackComponent
{

    const PAYSTACK_API_ROOT = 'https://api.paystack.co';
    const PRIVATE_KEY = 'sk_test_c78afeb208708f776932022c5ccfe976e2289chhj5d';


public function request($data =null)
    {
     $url = 'https://api.paystack.co/transaction/initialize';
        
    $data = json_encode($data);// sample of $data = '{"reference": "'.md5(time()).'", "amount": 500000, "email": "customer@email.com"}';
   
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);//set url
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);// return the response instead of printing
    curl_setopt($ch, CURLOPT_POST, true);// set the post method to true
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // SET THE DATA TO SEND
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Bearer '.PRIVATE_KEY ));
    $response = curl_exec($ch);//send the request and store the response in $response
    curl_close($ch);
    

    //$response contains json response from paystack which includes the payment url that the user will be redirected to complete payment, remember to set callback url in paystack dashboard, in the callback url call response('reference')
    
	return $response;//log transaction in this values to identify your transaction
    }


    
    public function response($ref){

      $url ='https://api.paystack.co/transaction/verify/'.$ref;    
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);//set url
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);// return the response instead of printing
      //curl_setopt($ch, CURLOPT_POST, true);// set the post method to true
      //curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // SET THE DATA TO SEND
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Bearer '.PRIVATE_KEY ));
      $response = curl_exec($ch);//send the request and store the response in $response
      curl_close($ch);
    
    return $response;//contains transaction details ( amount, payment status etc)
    }
    
    
}
