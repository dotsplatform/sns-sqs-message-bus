<?php
/**
 * Description of MessageBusServiceProvider.php.
 *
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace Dots\MessageBus;

use Aws\Credentials\Credentials;
use Aws\Sns\SnsClient;
use Dots\MessageBus\Dispatchers\AWSSqsSnsMessageJobDispatcher;
use Dots\MessageBus\Dispatchers\MessageJobDispatcher;
use Dots\MessageBus\Entities\MessageBusConnection;
use Dots\MessageBus\Resolvers\MessageBusRoutingKeysResolver;
use Illuminate\Support\ServiceProvider;
use RuntimeException;

class MessageBusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/message-bus.php', 'message-bus'
        );
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/message-bus.php' => config_path('message-bus.php'),
        ]);

        $this->bindDispatcher();
    }

    protected function bindDispatcher(): void
    {
        $connection = config('message-bus.default');
        switch ($connection) {
            case MessageBusConnection::SQS_SNS:
                $this->bindSNSClient();
                $this->app->bind(
                    MessageJobDispatcher::class,
                    AWSSqsSnsMessageJobDispatcher::class
                );
                $routingKeys = config('message-bus.connections.sqs-sns.routing_keys');
                break;
            default:
                throw new RuntimeException('MessageBus  connection:', $connection);
        }
        $this->bindRoutingKeys($routingKeys);
    }

    protected function bindSNSClient(): void
    {
        $this->app->when(SnsClient::class)
            ->needs('$args')
            ->give(fn () => [
                'version' => '',
                'region' => config('services.sns.region'),
                'credentials' => new Credentials(
                    config('services.sns.key'),
                    config('services.sns.secret')
                ),
            ]);
    }

    protected function bindRoutingKeys(array $routingKeys): void
    {
        $this->app->when(MessageBusRoutingKeysResolver::class)
            ->needs('$routingKeys')
            ->give(fn () => $routingKeys);
    }
}
