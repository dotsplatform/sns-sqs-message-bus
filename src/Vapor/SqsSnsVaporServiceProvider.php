<?php
/**
 * Description of DotsVaporServiceProvider.php.
 *
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace Dots\Vapor;

use Closure;
use Dots\Vapor\Console\Commands\SqsSnsVaporWorkCommand;
use Dots\Vapor\Queue\SqsSnsVaporConnector;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;

class SqsSnsVaporServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerCommands();
    }

    protected function registerCommands(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->app->singleton('command.vapor.work', function ($app) {
            return new SqsSnsVaporWorkCommand($app['queue.vaporWorker']);
        });

        $this->commands(['command.vapor.work']);
    }

    public function boot(): void
    {
        if ($this->app->resolved('queue')) {
            call_user_func($this->queueExtender());
        } else {
            $this->app->afterResolving(
                'queue',
                $this->queueExtender()
            );
        }
    }

    protected function queueExtender(): Closure
    {
        return function () {
            Queue::extend('sqs', function () {
                return new SqsSnsVaporConnector();
            });
        };
    }
}
