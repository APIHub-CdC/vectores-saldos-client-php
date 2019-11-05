<?php

namespace VectoresSaldos\Client;

use \GuzzleHttp\Client;
use \GuzzleHttp\HandlerStack;

use \VectoresSaldos\Client\Configuration;
use \VectoresSaldos\Client\ApiException;
use \VectoresSaldos\Client\Interceptor\KeyHandler;
use \VectoresSaldos\Client\Interceptor\MiddlewareEvents;

class VectoresSaldosApiTest extends \PHPUnit_Framework_TestCase
{
    protected $apiInstance;
    protected $signer;
    
    public function setUp()
    {
        $password = getenv('KEY_PASSWORD');
        $this->signer = new \VectoresSaldos\Client\Interceptor\KeyHandler(null, null, $password);
        $events = new \VectoresSaldos\Client\Interceptor\MiddlewareEvents($this->signer);
        $handler = \GuzzleHttp\HandlerStack::create();
        $handler->push($events->add_signature_header('x-signature'));
        $handler->push($events->verify_signature_header('x-signature'));
        $client = new \GuzzleHttp\Client([
            'handler' => $handler,
            'verify' => false
        ]);

        $config = new \VectoresSaldos\Client\Configuration();
        $config->setHost('the_url');

        $this->apiInstance = new \VectoresSaldos\Client\Api\VectoresSaldosApi($client);
    }
    public function testGetVectorSaldos()
    {
        $x_api_key = "your_api_key";
        $username = "your_username";
        $password = "your_password";
        $body = new \VectoresSaldos\Client\Model\Persona();
        $body->setPrimerNombre("XXXXX");
        $body->setSegundoNombre("XXXXX");
        $body->setApellidoPaterno("XXXXX");
        $body->setApellidoMaterno("XXXXX");
        $body->setApellidoAdicional("XXXXX");
        $body->setFechaNacimiento("YYY-MM-DD");
        $body->setRfc("XXXXX");
        $body->setCurp("XXXXX");
        $domicilio = new \VectoresSaldos\Client\Model\Domicilio();
        $domicilio->setDireccion("XXXXX");
        $domicilio->setColonia("XXXXX");
        $domicilio->setCiudad("XXXXX");
        $domicilio->setCodigoPostal("XXXXX");
        $domicilio->setMunicipio("XXXXX");
        $domicilio->setEstado("XXXX");
        $body->setDomicilio($domicilio);
        try {
            $result = $this->apiInstance->getVectorSaldos($x_api_key, $username, $password, $body);
            $this->signer->close();
            print_r($result);
        } catch (Exception $e) {
            echo 'Exception when calling VectoresSaldosApi->getVectorSaldos: ', $e->getMessage(), PHP_EOL;
        }
    }
}
