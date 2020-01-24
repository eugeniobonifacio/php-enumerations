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
use ReflectionClass;

class BasicConstantsInitializer implements EnumInitializerInterface
{
    protected $prefix = 'ENUM_';
    protected $enumInterfaceClass = null;

    /**
     * ReflectionConstantsInitializer constructor.
     * @param string $prefix
     */
    public function __construct($enumInterfaceClass, $prefix = null)
    {
        $this->enumInterfaceClass = $enumInterfaceClass;

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
            throw new EnumException("'" . get_class($this->enumInterfaceClass) ."' must implement EnumInterface");
        }

        try {
            $reflection = new ReflectionClass($this->enumInterfaceClass);

            $constants = $reflection->getConstants();

            foreach($constants as $k => $c) {
                if(strpos($k, $this->prefix) === 0) {

                    /** @var EnumInterface $v */
                    $v = $reflection->newInstanceWithoutConstructor();
                    $v->enumValueSet($c);
                    $values[$c] = $v;
                }
            }

            if(!$values) {
                throw new EnumException('No \'ENUM_\' prefixed constant found in class \'' . $this->enumInterfaceClass . '\'');
            }

            return new EnumContainer($values);

        } catch (\ReflectionException $e) {
            throw new EnumException($e->getMessage(), null, $e);
        }
    }
}