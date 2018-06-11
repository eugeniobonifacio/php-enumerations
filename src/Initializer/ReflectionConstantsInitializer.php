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
use ReflectionClass;

class ReflectionConstantsInitializer implements EnumInitializerInterface
{
    protected $enumInterfaceClass = null;

    /**
     * @var EnumInterface[]
     */
    protected $enumValues = null;
    protected $prefix = 'ENUM_';

    /**
     * ReflectionConstantsInitializer constructor.
     * @param string $prefix
     */
    public function __construct($enumInterfaceClass, $enumValues, $prefix = null)
    {
        $this->enumInterfaceClass = $enumInterfaceClass;
        $this->enumValues = $enumValues;

        if($prefix) {
            $this->prefix = $prefix;
        }
    }

    /**
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
            $reflection = new ReflectionClass($this->enumInterfaceClass);

            $constants = $reflection->getConstants();

            foreach($constants as $k => $c) {
                if(strpos($k, $this->prefix) === 0) {
                    $values[$k] = $c;
                }
            }

            $enumValuesKeys = [];
            foreach($this->enumValues as $ev) {
                $enumValuesKeys[] = $ev->enumValueGet();
            }

            $r = array_diff($enumValuesKeys, $values);

            if(count($r)) {
                throw new EnumMismatchException();
            }

            return new EnumContainer($values);

        } catch (\ReflectionException $e) {
            throw new EnumException($e->getMessage(), null, $e);
        }
    }
}