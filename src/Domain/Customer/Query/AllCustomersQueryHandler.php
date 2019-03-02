<?php

namespace Domain\Customer\Query;


use Domain\Core\QueryBus\QueryHandlerInterface;
use Domain\Core\QueryBus\QueryInterface;
use Domain\Customer\Signature\CustomerRepositoryInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class AllCustomersQueryHandler
 */
class AllCustomersQueryHandler implements QueryHandlerInterface
{
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var PaginatorInterface
     */
    private $paginator;

    /**
     * AllCustomersQueryHandler constructor.
     *
     * @param CustomerRepositoryInterface $customerRepository
     * @param PaginatorInterface          $paginator
     */
    public function __construct(CustomerRepositoryInterface $customerRepository, PaginatorInterface $paginator)
    {
        $this->customerRepository = $customerRepository;
        $this->paginator = $paginator;
    }
    /**
     * @param QueryInterface|AllCustomersQuery $query
     *
     * @return mixed
     */
    public function handle(QueryInterface $query)
    {
        $paginated = $this->paginator->paginate(
            $this->customerRepository
                ->queryBuilder()
                ->orderBy('shop_user.lastname')->getQuery(),
            $query->page,
            $query->limit
        );

        return $paginated;
    }
}
