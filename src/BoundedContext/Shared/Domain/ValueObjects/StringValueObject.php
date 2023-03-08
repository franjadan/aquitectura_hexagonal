<?php

declare(strict_types=1);

namespace Core\Shared\Domain\ValueObjects;

abstract class StringValueObject
{
    /*
        protected string $value;

        public function __construct(string $value){
            $this->value = $value;
        }
    */

    //Equivale al código comentado
    public function __construct(protected string $value) {}

    public function value(): string {
        return $this->value;
    }
}
