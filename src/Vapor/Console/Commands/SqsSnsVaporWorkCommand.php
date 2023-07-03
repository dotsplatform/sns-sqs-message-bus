<?php
/**
 * Description of VaporWorkCommand.php.
 *
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace Dots\Vapor\Console\Commands;

use Aws\Sqs\SqsClient;
use Dots\Vapor\Queue\SqsSnsVaporJob;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Queue\SqsQueue;
use Laravel\Vapor\Console\Commands\VaporWorkCommand;
use RuntimeException;

class SqsSnsVaporWorkCommand extends VaporWorkCommand
{
    /**
     * @throws BindingResolutionException
     */
    protected function marshalJob(array $message): SqsSnsVaporJob
    {
        $normalizedMessage = $this->normalizeMessage($message);

        /** @var Container $container */
        $container = $this->laravel;

        return new SqsSnsVaporJob(
            $container,
            $this->getSqsClient(),
            $normalizedMessage,
            'sqs',
            $this->queueUrl($message),
            $this->getSqsSnsVaporRoutes(),
        );
    }

    private function getSqsClient(): SqsClient
    {
        return $this->getSqsQueueConnection()->getSqs();
    }

    private function getSqsQueueConnection(): SqsQueue
    {
        $queue = $this->worker->getManager()->connection('sqs');
        if (! $queue instanceof SqsQueue) {
            throw new RuntimeException('No SQS Queue connection');
        }

        return $queue;
    }

    private function getSqsSnsVaporRoutes(): array
    {
        $routingKeys = config('message-bus.connections.sqs-sns.routing_keys');
        $routes = [];
        foreach ($routingKeys as $routingKey) {
            $routes[$routingKey['name']] = $routingKey['job'];
        }

        return $routes;
    }
}
