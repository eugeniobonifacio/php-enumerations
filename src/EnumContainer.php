<?php
/**
 * Created by PhpStorm.
 * User: eugenio
 * Date: 09/06/18
 * Time: 15.14
 */

namespace EugenioBonifacio\Enumerations;


class EnumContainer implements EnumContainerInterface
{
    /**
     * @var EnumInterface[]
     */
    protected $enumValues = null;

    /**
     * EnumContainer constructor.
     * @param EnumInterface[] $values
     */
    public function __construct(array $values)
    {
        $this->enumValues = $values;
    }

    /**
     * @param string $value
     * @return EnumInterface
     */
    public function enum($value)
    {
        if (isset($this->enumValues[$value])) {
            return $this->enumValues[$value];
        }

        return null;
    }

    /**
     * @param string $value
     * @return bool
     */
    public function has($value)
    {
        return isset($this->enumValues[$value]);
    }

    /**
     * @return EnumInterface[]
     */
    public function values()
    {
        return $this->enumValues;
    }

    /**
     * @return string[]
     */
    public function valuesKeys()
    {
        return array_keys($this->enumValues);
    }
}