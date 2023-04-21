<?php

namespace App\Providers;

use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;



class ElasticsearchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('elasticsearch', function ($app) {
            $config = $app['config']['database.connections.elasticsearch'];
            $builder = ClientBuilder::create()
                ->setHosts($config['hosts'])
                ->setRetries(2);
            if ($config['user'] && $config['pass']) {
                $builder->setBasicAuthentication($config['user'], $config['pass']);
            }
            return $builder->build();
        });

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}
