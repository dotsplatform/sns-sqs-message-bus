<?php

use Dots\MessageBus\Entities\RoutingKey;
use Dots\MessageBus\Jobs\SqsSnsIncomingMessageJob;

return [

    'default' => env('MESSAGE_BUS_CONNECTION', 'sqs-sns'),

    'connections' => [
        'sqs-sns' => [
            'key' => env('AWS_SNS_KEY'),
            'secret' => env('AWS_SNS_SECRET'),
            'region' => env('AWS_SNS_REGION', 'eu-west-1'),
            'version' => '2010-03-31',
            'routing_keys' => [
                RoutingKey::CMS => [
                    'name' => env('AWS_SNS_LIVESITE_TOPIC_ARN'),
                    'job' => SqsSnsIncomingMessageJob::class,
                ],
            ],
        ],
    ],

];
