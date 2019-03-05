<?php

namespace Domain\Product\Signature;

use Domain\Core\Signature\RepositoryInterface;

/**
 * Interface TagRepositoryInterface.
 */
interface TagRepositoryInterface extends RepositoryInterface
{
    public function getTags(array $names): array;

    public function oneByName(string $name): ?TagInterface;
}
