<?php
/**
 * VectoresSaldosApiTest
 */

namespace APIHub\Client;

use \GuzzleHttp\Client;
use \GuzzleHttp\HandlerStack;

use \APIHub\Client\ApiException;
use \APIHub\Client\Interceptor\KeyHandler;
use \APIHub\Client\Interceptor\MiddlewareEvents;

class VectoresSaldosApiTest extends \PHPUnit_Framework_TestCase
{
    protected $apiInstance;
    protected $signer;

    /**
     * Setup before running each test case
     */
    public function setUp()
    {
        $password = getenv('KEY_PASSWORD');
        $this->signer = new \APIHub\Client\Interceptor\KeyHandler(null, null, $password);
        $events = new \APIHub\Client\Interceptor\MiddlewareEvents($this->signer);
        $handler = \GuzzleHttp\HandlerStack::create();
        $handler->push($events->add_signature_header('x-signature'));
        $handler->push($events->verify_signature_header('x-signature'));

        $client = new \GuzzleHttp\Client([
            'handler' => $handler,
            'verify' => false
        ]);
        $this->apiInstance = new \APIHub\Client\Api\VectoresSaldosApi($client);
    }

    public function testGetVectorSaldos()
    {
        $x_api_key = "your_api_key";
        $username = "your_username";
        $password = "your_password";

        $body = new \APIHub\Client\Model\Persona();
        $body->setPrimerNombre("XXXXX");
        $body->setSegundoNombre("XXXXX");
        $body->setApellidoPaterno("XXXXX");
        $body->setApellidoMaterno("XXXXX");
        $body->setApellidoAdicional("XXXXX");
        $body->setFechaNacimiento("YYY-MM-DD");
        $body->setRfc("XXXXX");
        $body->setCurp("XXXXX");

        $domicilio = new \APIHub\Client\Model\Domicilio();
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
