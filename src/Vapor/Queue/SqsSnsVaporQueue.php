<?php
/**
 * Description of SqsSnsVaporQueue.php.
 *
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace Dots\Vapor\Queue;

use Aws\Result;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Queue\Job;
use Laravel\Vapor\Queue\VaporQueue;

class SqsSnsVaporQueue extends VaporQueue
{
    /**
     * Pop the next job off of the queue.
     *
     *
     * @throws BindingResolutionException
     */
    public function pop($queue = null): ?Job
    {
        $response = $this->sqs->receiveMessage([
            'QueueUrl' => $queue = $this->getQueue($queue),
            'AttributeNames' => ['ApproximateReceiveCount'],
        ]);
        if (! is_null($response['Messages']) && count($response['Messages']) > 0) {
            return $this->createJob($queue, $response);
        }

        return null;
    }

    /**
     * @throws BindingResolutionException
     */
    private function createJob(string $queue, Result $response): SqsSnsVaporJob
    {
        return new SqsSnsVaporJob(
            $this->container,
            $this->sqs,
            $response['Messages'][0],
            $this->connectionName,
            $queue,
            $this->getSqsSnsVaporRoutes(),
        );
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
