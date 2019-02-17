<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 17/02/19
 * Time: 23:16
 */

namespace Domain\Stock;


class StockRow
{
    /**
     * @var string
     */
    protected $id;
    /**
     * @var \DateTime
     */
    protected $recordOn;
    /**
     * @var mixed
     */
    protected $payload;

    /**
     * StockRow constructor.
     *
     * @param string $id
     * @param \DateTime $recordOn
     * @param mixed $payload
     */
    public function __construct(string $id, \DateTime $recordOn, $payload)
    {
        $this->id       = $id;
        $this->recordOn = $recordOn;
        $this->payload  = $payload;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getRecordOn(): \DateTime
    {
        return $this->recordOn;
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }


}
