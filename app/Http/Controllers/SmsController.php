<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vonage\Voice\NCCO\NCCO;

class SmsController extends Controller
{

      

public function envio(Request $request){
    $msg=$request->input('msg');
    $basic  = new \Vonage\Client\Credentials\Basic("56f49dcd", "Scp6iaCOReq7e72F");
$client = new \Vonage\Client($basic);
    $response = $client->sms()->send(
        new \Vonage\SMS\Message\SMS("258820825417", "MON", $msg)
    );
    
    $message = $response->current();
    
    if ($message->getStatus() == 0) {
        return json_encode("Enviado com sucesso!");
    } else {
        return json_encode("Falha ao enviar". $message->getStatus());
    }
    
    
    
 

    
}


public function Voz(){


    require_once __DIR__ . '/../../config.php';
    require_once __DIR__ . '/../../vendor/autoload.php';
    
    $keypair = new \Vonage\Client\Credentials\Keypair(
        file_get_contents(VONAGE_APPLICATION_PRIVATE_KEY_PATH),
        "APPLICATION_ID"
    );
    $client = new \Vonage\Client($keypair);
$outboundCall = new \Vonage\Voice\OutboundCall(
    new \Vonage\Voice\Endpoint\Phone("258820825417"),
    new \Vonage\Voice\Endpoint\Phone("258820825417")
);
$ncco = new NCCO();
$ncco->addAction(new \Vonage\Voice\NCCO\Action\Talk('This is a text to speech call from Nexmo'));
$outboundCall->setNCCO($ncco);

$response = $client->voice()->createOutboundCall($outboundCall);

return var_dump($response);


}


}
