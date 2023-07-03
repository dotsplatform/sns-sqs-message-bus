<?php
/**
 * Description of ProducesJob.php.
 *
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace Dots\MessageBus\Entities;

class AMPQMessage
{
    protected function __construct(
        private string $routingKey,
        private string $name,
        private array $data,
        private ?string $uniqueKey = null,
    ) {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            $data['routingKey'],
            $data['name'],
            $data['data'],
            $data['uniqueKey'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'routingKey' => $this->getRoutingKey(),
            'name' => $this->getName(),
            'data' => $this->getData(),
            'uniqueKey' => $this->getUniqueKey(),
        ];
    }

    public function getRoutingKey(): string
    {
        return $this->routingKey;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getUniqueKey(): ?string
    {
        return $this->uniqueKey;
    }
}
