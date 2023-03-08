<?php

declare(strict_types=1);

namespace Core\BoundedContext\Course\Domain;

use Core\Shared\Domain\DomainException;
use Throwable;

final class CourseAlreadyExists extends DomainException {
    public function __construct($message = "", $code = 0, Throwable $previous = null) {
        $message = "" === $message ? "Course already exists" : $message;

        parent::__construct($message, $code, $previous);
    }
}
