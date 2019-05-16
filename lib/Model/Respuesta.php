<?php

namespace APIHub\Client\Model;

use \ArrayAccess;
use \APIHub\Client\ObjectSerializer;

class Respuesta implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    protected static $apihubModelName = 'Respuesta';

    protected static $apihubTypes = [
        'periodo' => 'string',
        'monto_pagar' => 'float',
        'saldo_actual' => 'float',
        'saldo_vencido' => 'float',
        'frecuencia' => 'string',
        'calendario' => 'float'
    ];

    protected static $apihubFormats = [
        'periodo' => 'yyyy-MM-dd',
        'monto_pagar' => 'float',
        'saldo_actual' => 'float',
        'saldo_vencido' => 'float',
        'frecuencia' => null,
        'calendario' => 'float'
    ];

    public static function apihubTypes()
    {
        return self::$apihubTypes;
    }

    public static function apihubFormats()
    {
        return self::$apihubFormats;
    }

    protected static $attributeMap = [
        'periodo' => 'periodo',
        'monto_pagar' => 'montoPagar',
        'saldo_actual' => 'saldoActual',
        'saldo_vencido' => 'saldoVencido',
        'frecuencia' => 'frecuencia',
        'calendario' => 'calendario'
    ];

    protected static $setters = [
        'periodo' => 'setPeriodo',
        'monto_pagar' => 'setMontoPagar',
        'saldo_actual' => 'setSaldoActual',
        'saldo_vencido' => 'setSaldoVencido',
        'frecuencia' => 'setFrecuencia',
        'calendario' => 'setCalendario'
    ];

    protected static $getters = [
        'periodo' => 'getPeriodo',
        'monto_pagar' => 'getMontoPagar',
        'saldo_actual' => 'getSaldoActual',
        'saldo_vencido' => 'getSaldoVencido',
        'frecuencia' => 'getFrecuencia',
        'calendario' => 'getCalendario'
    ];

    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    public static function setters()
    {
        return self::$setters;
    }

    public static function getters()
    {
        return self::$getters;
    }

    public function getModelName()
    {
        return self::$apihubModelName;
    }

    protected $container = [];

    public function __construct(array $data = null)
    {
        $this->container['periodo'] = isset($data['periodo']) ? $data['periodo'] : null;
        $this->container['monto_pagar'] = isset($data['monto_pagar']) ? $data['monto_pagar'] : null;
        $this->container['saldo_actual'] = isset($data['saldo_actual']) ? $data['saldo_actual'] : null;
        $this->container['saldo_vencido'] = isset($data['saldo_vencido']) ? $data['saldo_vencido'] : null;
        $this->container['frecuencia'] = isset($data['frecuencia']) ? $data['frecuencia'] : null;
        $this->container['calendario'] = isset($data['calendario']) ? $data['calendario'] : null;
    }

    public function listInvalidProperties()
    {
        $invalidProperties = [];

        return $invalidProperties;
    }

    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }

    public function getPeriodo()
    {
        return $this->container['periodo'];
    }

    public function setPeriodo($periodo)
    {
        $this->container['periodo'] = $periodo;

        return $this;
    }

    public function getMontoPagar()
    {
        return $this->container['monto_pagar'];
    }

    public function setMontoPagar($monto_pagar)
    {
        $this->container['monto_pagar'] = $monto_pagar;

        return $this;
    }

    public function getSaldoActual()
    {
        return $this->container['saldo_actual'];
    }

    public function setSaldoActual($saldo_actual)
    {
        $this->container['saldo_actual'] = $saldo_actual;

        return $this;
    }

    public function getSaldoVencido()
    {
        return $this->container['saldo_vencido'];
    }

    public function setSaldoVencido($saldo_vencido)
    {
        $this->container['saldo_vencido'] = $saldo_vencido;

        return $this;
    }

    public function getFrecuencia()
    {
        return $this->container['frecuencia'];
    }

    public function setFrecuencia($frecuencia)
    {
        $this->container['frecuencia'] = $frecuencia;

        return $this;
    }

    public function getCalendario()
    {
        return $this->container['calendario'];
    }

    public function setCalendario($calendario)
    {
        $this->container['calendario'] = $calendario;

        return $this;
    }

    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}


