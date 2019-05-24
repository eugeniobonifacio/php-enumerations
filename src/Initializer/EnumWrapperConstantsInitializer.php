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
use EugenioBonifacio\Enumerations\EnumMismatchException;
use EugenioBonifacio\Enumerations\EnumWrapper;
use ReflectionClass;

class EnumWrapperConstantsInitializer implements EnumInitializerInterface
{
    protected $prefix = 'ENUM_';
    protected $enumInterfaceClass = null;
    protected $callback = null;

    /**
     * ReflectionConstantsInitializer constructor.
     * @param string $prefix
     */
    public function __construct($enumInterfaceClass, callable $callback, $prefix = null)
    {
        $this->enumInterfaceClass = $enumInterfaceClass;
        $this->callback = $callback;

        if($prefix) {
            $this->prefix = $prefix;
        }
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
            throw new EnumException("'" . $this->enumInterfaceClass ."' must implement EnumInterface");
        }

        try {
            $reflection = new ReflectionClass($this->enumInterfaceClass);

            $constants = $reflection->getConstants();

            foreach($constants as $k => $c) {
                if(strpos($k, $this->prefix) === 0) {
                    $values[$k] = $c;
                }
            }

            $cb = $this->callback;
            /** @var EnumWrapper[] $enumWrappers */
            $enumWrappers = $cb($this->enumInterfaceClass);
            $enumValues = [];
            $enumValuesKeys = [];
            foreach($enumWrappers as $ev) {
                $enumValuesKeys[] = $ev->getKey();
                $enumValues[$ev->getKey()] = $ev->getValue();
            }

            $r = array_diff($values, $enumValuesKeys);

            if(count($r)) {
                throw new EnumMismatchException();
            }

            return new EnumContainer($enumValues);

        } catch (\ReflectionException $e) {
            throw new EnumException($e->getMessage(), null, $e);
        }
    }
}