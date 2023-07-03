<?php
/**
 * Description of RoutingKeys.php.
 *
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace Dots\MessageBus\Resolvers;

use RuntimeException;

class MessageBusRoutingKeysResolver
{
    private array $routingKeys;

    public function __construct(
        array $routingKeys
    ) {
        $this->routingKeys = $routingKeys;
    }

    public function resolve(string $key): string
    {
        if (empty($this->routingKeys[$key]['name'])) {
            throw new RuntimeException("MessageBus Roting key $key not found");
        }

        return $this->routingKeys[$key]['name'];
    }
}
