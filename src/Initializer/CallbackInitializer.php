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
        $values = [];

        if(!in_array(EnumInterface::class, class_implements($this->enumInterfaceClass))) {
            throw new EnumException("'" . get_class($this->enumInterfaceClass) ."' must implement EnumInterface");
        }

        try {
            /** @var EnumInterface[] $enumValues */
            $enumValues = ($this->callback)($this->enumInterfaceClass);
            $enumValuesKeys = [];
            foreach($enumValues as $ev) {
                $enumValuesKeys[] = $ev->enumValueGet();
            }

            return new EnumContainer($enumValues);

        } catch (\ReflectionException $e) {
            throw new EnumException($e->getMessage(), null, $e);
        }
    }
}