<?php
/**
 * Created by PhpStorm.
 * User: eugenio
 * Date: 09/06/18
 * Time: 12.09
 */

namespace EugenioBonifacio\Enumerations\Initializer;


use EugenioBonifacio\Enumerations\Enum;
use EugenioBonifacio\Enumerations\EnumInitializerInterface;
use EugenioBonifacio\Enumerations\EnumInterface;

class CallbackInitializer implements EnumInitializerInterface
{
    /**
     * @return Enum
     */
    public function enumInit(EnumInterface $enum, $values = [])
    {
        $this->values = $values;

        if(!in_array(EnumInterface::class, class_implements($class))) {
            throw new EnumException("'" . get_class($class) ."' must implement EnumInterface");
        }

        try {
            $reflection = new ReflectionClass($class);

            $constants = $reflection->getConstants();

            $r = array_diff(array_keys($this->values), $constants);

            if(count($r)) {
                throw new EnumMismatchException();
            }

        } catch (\ReflectionException $e) {
            throw new EnumException($e->getMessage(), null, $e);
        }
    }
}