<?php

namespace Domain\Core\QueryBus\Exception;

use Throwable;

/**
 * Class NoHandlerForQueryException
 */
class NoHandlerForQueryException extends \Exception
{
    /**
     * @var string
     */
    protected $format = 'No handler found for %s';

    /**
     * NoHandlerForQueryException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf($this->format, $message), $code, $previous);
    }
}
