<?php
/*
 *  Copyright 2022.  Baks.dev <admin@baks.dev>
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *   limitations under the License.
 *
 */

declare(strict_types=1);

namespace BaksDev\Reference\Peel\Type;

use BaksDev\Reference\Peel\Type\Peels\PeelsInterface;

final class Peel
{

    public const string TYPE = 'peels_type';

    private ?PeelsInterface $peels = null;


    public function __construct(self|string|PeelsInterface $peels)
    {
        if($peels instanceof PeelsInterface)
        {
            $this->peels = $peels;
        }

        if($peels instanceof $this)
        {
            $this->peels = $peels->getPeel();
        }

        if(is_string($peels))
        {
            /** @var PeelsInterface $class */
            foreach(self::getDeclaredPeels() as $class)
            {
                if($class::equals($peels))
                {
                    $this->peels = new $class;
                    break;
                }
            }
        }

    }


    public function __toString(): string
    {
        return $this->peels ? $this->peels->getvalue() : '';
    }


    /** Возвращает значение ColorsInterface */
    public function getPeel(): PeelsInterface
    {
        return $this->peels;
    }


    /** Возвращает значение ColorsInterface */
    public function getPeelValue(): string
    {
        return $this->peels?->getValue() ?: '';
    }


    public static function cases(): array
    {
        $case = [];

        foreach(self::getDeclaredPeels() as $key => $peels)
        {
            /** @var PeelsInterface $peels */
            $peels = new $peels;
            $case[$peels::sort().$key] = new self($peels);
        }

        ksort($case);

        return $case;
    }


    public static function getDeclaredPeels(): array
    {
        return array_filter(
            get_declared_classes(),
            static function($className) {
                return in_array(PeelsInterface::class, class_implements($className), true);
            },
        );
    }

}