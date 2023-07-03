<?php
/**
 * Description of SqsSnsVaporJob.php.
 *
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace Dots\Vapor\Queue;

use Aws\Sqs\SqsClient;
use Dots\MessageBus\Jobs\SqsSnsIncomingMessageJob;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Queue\CallQueuedHandler;
use Laravel\Vapor\Queue\VaporJob;

class SqsSnsVaporJob extends VaporJob
{
    public const DEFAULT_MAX_TRIES = 10;

    /**
     *  @note: We have logic of locking duplicated events.
     *         That is ehy we need to set increased max tries, to prevent situation,
     *         when job is not processed due to max attempts.
     */
    public function maxTries(): ?int
    {
        $maxTries = parent::maxTries();
        if (! is_null($maxTries)) {
            return $maxTries;
        }
        $maxTries = config('queue.sqs.sqs-sns.tries', self::DEFAULT_MAX_TRIES);
        if (! is_numeric($maxTries)) {
            return null;
        }

        return (int) $maxTries;
    }

    /**
     * Create a new job instance.
     *
     * @return void
     *
     * @throws BindingResolutionException
     */
    public function __construct(
        Container $container,
        SqsClient $sqs,
        array $job,
        string $connectionName,
        string $queue,
        array $routes
    ) {
        parent::__construct($container, $sqs, $job, $connectionName, $queue);
        $this->ensureJobIsResolved($routes);
    }

    /**
     * @throws BindingResolutionException
     */
    private function ensureJobIsResolved(array $routes): void
    {
        $this->job = $this->resolveSnsSubscription($this->job, $routes);
    }

    /**
     * Resolves SNS queue messages.
     *
     *
     * @throws BindingResolutionException
     */
    protected function resolveSnsSubscription(array $job, array $routes): array
    {
        $body = json_decode($job['Body'], true) ?: [];
        if (! empty($body['job'])) {
            return $job;
        }

        $commandName = $this->resolveCommandName($body, $routes);
        // If there is a command available, we will resolve the job instance for it from
        // the service container, passing in the subject and the payload of the
        // notification.
        $command = $this->makeCommand($commandName, $body);

        // The instance for the job will then be serialized and the body of
        // the job is reconstructed.

        $job['Body'] = json_encode([
            'uuid' => $job['MessageId'],
            'displayName' => $commandName,
            'job' => CallQueuedHandler::class.'@call',
            'data' => compact('commandName', 'command'),
        ]);

        return $job;
    }

    public function resolveCommandName(array $body, array $routes): string
    {
        $commandName = $this->resolveCommandNameFromRouteParams($body, $routes);
        if (! $commandName) {
            return $this->getDefaultSqsSnsIncomingMessageJob();
        }

        return $commandName;
    }

    private function resolveCommandNameFromRouteParams(array $body, array $routes): ?string
    {
        if (empty($body) || empty($routes)) {
            return null;
        }
        $possibleRouteParams = $this->getPossibleRouteParamsToRouteJob();

        foreach ($possibleRouteParams as $param) {
            if (isset($body[$param]) && array_key_exists($body[$param], $routes)) {
                // Find name of command in queue routes using the param field
                return $routes[$body[$param]];
            }
        }

        return null;
    }

    private function getPossibleRouteParamsToRouteJob(): array
    {
        return [
            'Subject',
            'TopicArn',
        ];
    }

    private function getDefaultSqsSnsIncomingMessageJob(): string
    {
        return SqsSnsIncomingMessageJob::class;
    }

    /**
     * Make the serialized command.
     *
     *
     * @throws BindingResolutionException
     */
    protected function makeCommand(string $commandName, array $body): string
    {
        $payload = [];
        if (! empty($body['Message'])) {
            $payload = json_decode($body['Message'], true);
        }

        $data = [
            'subject' => (isset($body['Subject'])) ? $body['Subject'] : '',
            'payload' => $payload,
        ];
        $instance = $this->container->make($commandName, $data);

        return serialize($instance);
    }
}
