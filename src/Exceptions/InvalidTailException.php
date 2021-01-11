<?php

namespace JWorman\Statistics\Exceptions;

class InvalidTailException extends \InvalidArgumentException
{
    /**
     * @param string $invalidTail
     */
    public function __construct($invalidTail)
    {
        $message = \sprintf('Invalid tail argument given: %s. Use the *_TAIL constants instead.', $invalidTail);
        parent::__construct($message);
    }
}
