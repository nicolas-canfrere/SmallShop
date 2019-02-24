<?php

namespace Domain\Core\CommandBus\Exception;

use Throwable;

/**
 * Class NoHandlerForCommandException
 */
class NoHandlerForCommandException extends \Exception
{
    /**
     * @var string
     */
    protected $format = 'No handler found for %s';

    /**
     * NoHandlerForCommandException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf($this->format, $message), $code, $previous);
    }

}
