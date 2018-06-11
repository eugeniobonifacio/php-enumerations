<?php
/**
 * Copyright 2018 Eugenio Bonifacio <mail@eugeniobonifacio.com>
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */

namespace EugenioBonifacio\Enumerations;


use EugenioBonifacio\Enumerations\Initializer\BasicConstantsInitializer;

class Enum
{
    /** @var array EnumContainer */
    protected static $enums = [];

    /** @var EnumInitializerInterface[] */
    protected static $initializers = [];

    protected static $defaultInitializer = BasicConstantsInitializer::class;

    /**
     * @param $enumInterfaceClass
     * @return EnumContainer
     * @throws EnumException
     */
    public static function get($enumInterfaceClass)
    {
        if(isset(self::$enums[$enumInterfaceClass])) {
            return self::$enums[$enumInterfaceClass];
        }
        elseif(isset(self::$initializers[$enumInterfaceClass])) {
            self::$enums[$enumInterfaceClass] = self::$initializers[$enumInterfaceClass]->enumInit();
            return self::$enums[$enumInterfaceClass];
        }
        elseif(method_exists($enumInterfaceClass, 'enumInit')) {

            $result = call_user_func([$enumInterfaceClass, 'enumInit']);

            if($result instanceof EnumContainer) {
                self::$enums[$enumInterfaceClass] = $result;
            }
            else {
                throw new EnumException("Enum '" . $enumInterfaceClass . "' static enumInit() did not return an '" . EnumContainer::class . "' object");
            }

            return self::$enums[$enumInterfaceClass];
        }

        throw new EnumException("Enum not defined for class '{$enumInterfaceClass}'");
    }

    /**
     * @param $enumInterfaceClass
     * @param EnumInitializerInterface $initializer
     * @throws EnumException
     */
    public static function setInitializer($enumInterfaceClass, EnumInitializerInterface $initializer)
    {
        if(!in_array(EnumInterface::class, class_implements($enumInterfaceClass))) {
            throw new EnumException("'" . get_class($enumInterfaceClass) ."' must implement " . EnumInterface::class);
        }

        if(isset(self::$enums[$enumInterfaceClass])) {
            throw new EnumException("Enum already initialized");
        }

        self::$initializers[$enumInterfaceClass] = $initializer;
    }
}