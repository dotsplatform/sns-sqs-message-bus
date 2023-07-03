<?php
/**
 * Description of Pyaload.php.
 *
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace Dots\MessageBus\Entities;

class MessagePayload
{
    private function __construct(
        private string $name,
        private array $data,
    ) {
    }

    public static function fromAMPQJob(AMPQMessage $ampqMessageJob): static
    {
        return self::fromArray([
            'name' => $ampqMessageJob->getName(),
            'data' => $ampqMessageJob->getData(),
        ]);
    }

    public static function fromArray(array $data): static
    {
        return new static(
            $data['name'],
            $data['data'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'data' => $this->data,
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
