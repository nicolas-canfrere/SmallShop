<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 17/02/19
 * Time: 20:19
 */

namespace Domain\Product\Bundle\Query;


class PaginatedProductsQuery
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
     * @param int $page
     * @param int|null $limit
     */
    public function __construct(int $page, ?int $limit = 10)
    {
        $this->page  = $page;
        $this->limit = $limit;
    }


}
