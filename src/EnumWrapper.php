<?php
/**
 * Created by PhpStorm.
 * User: Eugenio Bonifacio
 * Date: 22/05/19
 * Time: 11.26
 */

namespace EugenioBonifacio\Enumerations;


class EnumWrapper
{
    /** @var string */
    protected $key;

    /** @var object */
    protected $value;

    /**
     * EnumWrapper constructor.
     * @param string $key
     * @param object $value
     */
    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return EnumWrapper
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return object
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param object $value
     * @return EnumWrapper
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}