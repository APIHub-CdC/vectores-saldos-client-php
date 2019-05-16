# Cliente Vectores de Saldos (PHP)
Vectores de Saldos devuelve un vector con los saldos de la persona en cuestión. La información es mensual, comprende un periodo de 12 meses más el mes en curso e incluye el monto a pagar y los saldos actual y vencido.

## Requisitos
PHP 7.1 ó superior

### Dependencias adicionales
- Las siguientes dependencias de PHP son requeridas:
    - ext-curl
    - ext-mbstring
- Ejemplo de instalación (Linux):

```sh
apt-get install php7.3-curl
apt-get install php7.3-mbstring
```
- Composer [ver como instalar][1]

## Instalación
```sh
composer install
```

## Guía de inicio

### Paso 1. Generación de llave y certificado

- Es necesario contar con un contenedor en formato PKCS12; en caso de no contar con uno, ejecutar el script **lib/Interceptor/key_pair_gen.sh** ó llevar a cabo los siguientes pasos:

```sh
# Definición de nombres de archivos y alias.
export PRIVATE_KEY_FILE=pri_key.pem
export CERTIFICATE_FILE=certificate.pem
export SUBJECT=/C=MX/ST=MX/L=MX/O=CDC/CN=CDC
export PKCS12_FILE=keypair.p12
export ALIAS=circulo_de_credito

# Opcionalmente, para cifrar el contenedor, colocar una contraseña en una variable de ambiente.
export KEY_PASSWORD=your_password

#Generación de llave privada.
openssl ecparam -name secp384r1 -genkey -out ${PRIVATE_KEY_FILE}

#Generación de certificado público.
openssl req -new -x509 -days 365 \
    -key ${PRIVATE_KEY_FILE} \
    -out ${CERTIFICATE_FILE} \
    -subj "${SUBJECT}"

# Generación de archivo pkcs12 a partir de llave privada y certificado.
# Se deberá empaquetar la llave privada y el certificado.
openssl pkcs12 -name ${ALIAS} \
    -export -out ${PKCS12_FILE} \
    -inkey ${PRIVATE_KEY_FILE} \
    -in ${CERTIFICATE_FILE} -password pass:${KEY_PASSWORD}
```

### Paso 2. Carga del certificado dentro del portal de desarrolladores

 1. Iniciar sesión.
 2. Dar clic en la sección "**Mis aplicaciones**".
 3. Seleccionar la aplicación.
 4. Ir a la pestaña de "**Certificados para @tuApp**".
<p align="center">
  <img src="https://github.com/APIHub-CdC/imagenes-cdc/blob/master/applications.png" width="268">
</p>
 5. Al abrirse la ventana emergente, seleccionar el certificado previamente creado y dar clic en el botón "**Cargar**":
<p align="center">
  <img src="https://github.com/APIHub-CdC/imagenes-cdc/blob/master/upload_cert.png" width="268">
</p>

### Paso 3. Descarga del certificado de Círculo de Crédito dentro del portal de desarrolladores

 1. Iniciar sesión.
 2. Dar clic en la sección "**Mis aplicaciones**".
 3. Seleccionar la aplicación.
 4. Ir a la pestaña de "**Certificados para @tuApp**".
<p align="center">
  <img src="https://github.com/APIHub-CdC/imagenes-cdc/blob/master/applications.png" width="268">
</p>

 4. Al abrirse la ventana emergente, dar clic al botón "**Descargar**":
<p align="center">
  <img src="https://github.com/APIHub-CdC/imagenes-cdc/blob/master/download_cert.png" width="268">
</p>

 - Es importante que tanto el contenedor, como el certificado proporcionado por Círculo de Crédito, sean almacenados en las siguientes rutas:
 > - **/path/to/repository/lib/Interceptor/keypair.p12**
 > - **/path/to/repository/lib/Interceptor/cdc_cert.pem**
 
 - En caso de que no sean almacenados de esta forma, es necesario especificar la ruta en la que se encuentra el contenedor y el certificado (véase el ejemplo siguiente):
```php
  $password = getenv('KEY_PASSWORD');
  $this->signer = new \APIHub\Client\Interceptor\KeyHandler(
    "/example/route/keypair.p12",
    "/example/route/cdc_cert.pem",
    $password
  );
```
 > **NOTA:** Solo en caso de que el contenedor se haya cifrado, deberá colocarse la contraseña en una variable de ambiente e indicarse el nombre de la misma.

### Paso 4. Modificación de URL

 - Modificar la URL de la petición en ***lib/Configuration.php*** (línea 19):

 ```php
  protected $host = 'the_url';
 ```

### Paso 5. Captura de datos de petición

- Es preciso contar con la función **setUp()** encargada de la firma y verificación de la petición.

```php
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
```

```php
/**
* Método de prueba, ubicado en: path/to/repository/test/Api/VectoresSaldosApiTest.php
*/
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
?>
```

## Pruebas unitarias

- Para ejecutar las pruebas unitarias:

```sh
./vendor/bin/phpunit
```

[1]: https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos
