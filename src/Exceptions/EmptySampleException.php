<?php

namespace JWorman\Statistics\Exceptions;

class EmptySampleException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Statistics cannot be performed on an empty sample.');
    }
}
