<?php
/**
 * Created by PhpStorm.
 * User: eugenio
 * Date: 09/06/18
 * Time: 12.09
 */

namespace EugenioBonifacio\Enumerations\Initializer;


use EugenioBonifacio\Enumerations\EnumContainer;
use EugenioBonifacio\Enumerations\EnumException;
use EugenioBonifacio\Enumerations\EnumInitializerInterface;
use EugenioBonifacio\Enumerations\EnumInterface;
use EugenioBonifacio\Enumerations\EnumValue;

class CallbackInitializer implements EnumInitializerInterface
{
    protected $enumInterfaceClass = null;
    protected $callback = null;

    /**
     * ReflectionConstantsInitializer constructor.
     * @param string $prefix
     */
    public function __construct($enumInterfaceClass, callable $callback)
    {
        $this->enumInterfaceClass = $enumInterfaceClass;
        $this->callback = $callback;
    }

    /**
     * @param string $enumInterfaceClass
     * @param EnumInterface[] $enumValues
     * @return EnumContainer
     * @throws EnumException
     */
    public function enumInit()
    {
        if(!in_array(EnumInterface::class, class_implements($this->enumInterfaceClass))) {
            throw new EnumException("'" . get_class($this->enumInterfaceClass) ."' must implement EnumInterface");
        }

        try {
            $cb = $this->callback;
            /** @var EnumInterface[] $values */
            $values = $cb($this->enumInterfaceClass);
            $enumValuesKeys = [];
            $enumValues = [];
            foreach($values as $ev) {
                $enumValuesKeys[] = $ev->enumValueGet();
                $enumValues[$ev->enumValueGet()] = new EnumValue($ev->enumValueGet(), $ev);
            }

            return new EnumContainer($enumValues);

        } catch (\ReflectionException $e) {
            throw new EnumException($e->getMessage(), null, $e);
        }
    }
}