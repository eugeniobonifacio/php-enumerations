<?php
/**
 * Created by PhpStorm.
 * User: eugenio
 * Date: 09/06/18
 * Time: 12.09
 */

namespace EugenioBonifacio\Enumerations\Initializer;


use EugenioBonifacio\Enumerations\EnumInitializerInterface;

class ReflectionMethodsInitializer implements EnumInitializerInterface
{
//    /**
//     * @return Enum
//     * @throws EnumException
//     */
    public function enumInit()
    {
//        $values = [];
//
//        if(!in_array(EnumInterface::class, class_implements($enumInterfaceClass))) {
//            throw new EnumException("'" . get_class($enumInterfaceClass) ."' must implement EnumInterface");
//        }
//
//        try {
//            $reflection = new ReflectionClass($enumInterfaceClass);
//
//            $methods = $reflection->getMethods(ReflectionMethod::IS_STATIC | ReflectionMethod::IS_PUBLIC);
//
//            foreach($methods as $m) {
//                $comment = $m->getDocComment();
//
//                if(preg_match_all('/\s@enum\s/')) {
//                    $values =
//                }
//            }
//
//            $r = array_diff(array_keys($this->values), $constants);
//
//            if(count($r)) {
//                throw new EnumMismatchException();
//            }
//
//        } catch (\ReflectionException $e) {
//            throw new EnumException($e->getMessage(), null, $e);
//        }
    }
}