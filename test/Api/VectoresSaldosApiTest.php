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
        $this->signer = new \APIHub\Client\Interceptor\KeyHandler("/Users/apadilla/Desktop/test-clientes/certificados/keypair.p12", "/Users/apadilla/Desktop/test-clientes/certificados/cdc_cert.pem", $password);
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
        $x_api_key = "Ih1v0By4lsy7HOxGRcwkGCp92TAJ4Dje";
        $username = "IHM0915CMI";
        $password = "pr3uBa8l";

        $body = new \APIHub\Client\Model\Persona();
        $body->setPrimerNombre("ROBERTO");
        $body->setSegundoNombre(null);
        $body->setApellidoPaterno("SAHAGUN");
        $body->setApellidoMaterno("ZARAGOZA");
        $body->setApellidoAdicional(null);
        $body->setFechaNacimiento("2001-01-01");
        $body->setRfc("SAZR010101");
        $body->setCurp(null);

        $domicilio = new \APIHub\Client\Model\Domicilio();
        $domicilio->setDireccion("HIDALGO 32");
        $domicilio->setColonia(null);
        $domicilio->setCiudad(null);
        $domicilio->setCodigoPostal("47917");
        $domicilio->setMunicipio("LA BARCA");
        $domicilio->setEstado("JAL");

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
