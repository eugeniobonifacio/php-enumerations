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


/**
 * Trait EnumTrait
 * @package EugenioBonifacio\Enumerations
 */
trait EnumTrait
{
    /**
     * @var EnumContainer
     */
    protected static $enumContainer = null;

    /**
     * @param string $value
     * @return EnumContainer|\EugenioBonifacio\Enumerations\EnumInterface|self
     */
    public static function enum($value = null)
    {
        if (self::$enumContainer === null) {
            try {
                self::$enumContainer = Enum::get(get_called_class());
            } catch (EnumException $e) {
                throw new \RuntimeException($e->getMessage(), 0, $e);
            }
        }

        if ($value === null) {
            return self::$enumContainer;
        }

        return self::$enumContainer->v($value);
    }

    /**
     * @param string|EnumInterface|EnumInterface[] $value
     * @return boolean
     */
    public function equals($value)
    {
        if ($value instanceof EnumInterface) {
            $value = [$value];
        } elseif (is_string($value)) {
            return ($this->enumValueGet() === $value);
        }

        foreach ($value as $v) {
            if ($this->enumValueGet() == $v->enumValueGet()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $value
     * @return bool
     */
    public static function has($value)
    {
        if (!is_scalar($value)) {
            return false;
        }

        $value = "$value";

        return self::enum()->has($value);
    }

    /**
     * @return EnumInterface[]|null
     */
    public static function values()
    {
        return self::enum()->values();
    }

    /**
     * @return string[]
     */
    public static function valuesKeys()
    {
        return self::enum()->valuesKeys();
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->enumValueGet();
    }
}