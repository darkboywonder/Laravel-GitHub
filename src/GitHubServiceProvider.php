<?php

/**
 * This file is part of Laravel GitHub by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace GrahamCampbell\GitHub;

use Illuminate\Support\ServiceProvider;

/**
 * This is the github service provider class.
 *
 * @package    Laravel-GitHub
 * @author     Graham Campbell
 * @copyright  Copyright 2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-GitHub/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-GitHub
 */
class GitHubServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('graham-campbell/github', 'graham-campbell/github', __DIR__);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerGitHubManager();
    }

    /**
     * Register the github manager class.
     *
     * @return void
     */
    protected function registerGitHubManager()
    {
        $this->app->bindShared('github', function ($app) {
            $config = $app['config'];
            $path = $app['path.storage'] . '/github';
            $factory = new Factories\GitHubFactory($path);

            return new GitHubManager($config, $factory);
        });

        $this->app->alias('github', 'GrahamCampbell\GitHub\GitHubManager');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return array(
            'github'
        );
    }
}
