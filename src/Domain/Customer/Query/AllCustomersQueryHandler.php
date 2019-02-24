<?php

namespace Domain\Customer\Query;

use Domain\Core\Signature\QueryHandlerInterface;
use Domain\Customer\Signature\CustomerRepositoryInterface;
use Knp\Component\Pager\PaginatorInterface;

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

    public function handle(AllCustomersQuery $query)
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
