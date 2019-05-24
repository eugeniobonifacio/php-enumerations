<?php
/**
 * Created by PhpStorm.
 * User: Eugenio Bonifacio
 * Date: 22/05/19
 * Time: 11.26
 */

namespace EugenioBonifacio\Enumerations;


class EnumValue implements EnumValueInterface
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
     * @return EnumValue
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
     * @return EnumValue
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    public function hashValue()
    {
        return md5(get_class($this->getValue()) . ':' . $this->getKey());
    }

    /**
     * @return string
     */
    public function enumValueGet()
    {
        return $this->getKey();
    }

    /**
     * @return self
     */
    public function enumValueSet($value)
    {
        return $this->setKey($value);
    }
}