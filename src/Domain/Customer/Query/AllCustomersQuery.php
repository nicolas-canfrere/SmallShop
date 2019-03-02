<?php

namespace Domain\Customer\Query;

use Domain\Core\QueryBus\QueryInterface;

/**
 * Class AllCustomersQuery.
 */
class AllCustomersQuery implements QueryInterface
{
    /**
     * @var int
     */
    public $page;

    /**
     * @var int|null
     */
    public $limit;

    /**
     * PaginatedProductsQuery constructor.
     *
     * @param int      $page
     * @param int|null $limit
     */
    public function __construct(int $page, ?int $limit = 10)
    {
        $this->page = $page;
        $this->limit = $limit;
    }

    /**
     * @return string
     */
    public function handleBy(): string
    {
        return AllCustomersQueryHandler::class;
    }
}
