<?php
/**
 * Created by PhpStorm.
 * User: eugenio
 * Date: 09/06/18
 * Time: 15.14
 */

namespace EugenioBonifacio\Enumerations;


class EnumContainer
{
    protected $enumValues = null;

    /**
     * EnumContainer constructor.
     * @param EnumInterface[] $values
     */
    public function __construct($values)
    {
        $this->enumValues = $values;
    }

    /**
     * @param string $value
     * @return EnumInterface
     */
    public function v($value)
    {
        if(isset($this->enumValues[$value])) {
            return $this->enumValues[$value];
        }

        return null;
    }


}