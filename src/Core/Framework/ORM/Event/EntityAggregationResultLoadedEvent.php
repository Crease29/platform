<?php declare(strict_types=1);

namespace Shopware\Core\Framework\ORM\Event;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Event\NestedEvent;
use Shopware\Core\Framework\ORM\EntityDefinition;
use Shopware\Core\Framework\ORM\Search\AggregatorResult;

class EntityAggregationResultLoadedEvent extends NestedEvent
{
    /**
     * @var AggregatorResult
     */
    protected $result;

    /**
     * @var string|EntityDefinition
     */
    protected $definition;

    /**
     * @var string
     */
    protected $name;

    public function __construct(string $definition, AggregatorResult $result)
    {
        $this->result = $result;
        $this->definition = $definition;
        $this->name = $this->definition::getEntityName() . '.aggregation.result.loaded';
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getContext(): Context
    {
        return $this->result->getContext();
    }

    public function getResult(): AggregatorResult
    {
        return $this->result;
    }
}
