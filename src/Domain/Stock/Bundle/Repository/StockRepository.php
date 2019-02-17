<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 17/02/19
 * Time: 23:08
 */

namespace Domain\Stock\Bundle\Repository;


use Doctrine\ORM\EntityManagerInterface;
use Domain\EventSourcing\AggregateInterface;
use Domain\EventSourcing\EventStream;
use Domain\Stock\Signature\StockRepositoryInterface;
use Domain\Stock\Stock;
use Domain\Stock\StockRow;

class StockRepository implements StockRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    public function save(AggregateInterface $aggregate)
    {
        $events = $aggregate->getUncommittedEvents();
        foreach ($events as $event) {
            $row = new StockRow($aggregate->getId(), new \DateTime(), $event);
            $this->entityManager->persist($row);

        }
        $this->entityManager->flush();
    }

    public function load($id): AggregateInterface
    {
        $qb = $this->entityManager->createQueryBuilder()->select('stockRow')->from(StockRow::class, 'stockRow');
        $qb->andWhere('stockRow.id = :id')->setParameter('id', $id);
        $qb->addOrderBy('stockRow.recordOn', 'ASC');
        $rows   = $qb->getQuery()->getResult();
        $events = [];
        foreach ($rows as $row) {
            $events[] = $row->getPayload();
        }

        return Stock::initialize(new EventStream($events));

    }
}
