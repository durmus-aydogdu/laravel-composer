<?php

namespace DurmusAydogdu\LaravelComposer;

use Illuminate\Support\ServiceProvider;

class ComposerCommandServiceProvider extends ServiceProvider
{
    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        'ComposerRun' => 'command.composer.run',
        'ComposerUpdate' => 'command.composer.update',
        'ComposerRemove' => 'command.composer.remove',
        'ComposerRequire' => 'command.composer.require',
        'ComposerInstall' => 'command.composer.install',
        'ComposerClearCache' => 'command.composer.clear-cache',
        'ComposerDumpAutoload' => 'command.composer.dump-autoload',
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands(
            $this->commands
        );
    }

    /**
     * Register the given commands.
     *
     * @param  array  $commands
     * @return void
     */
    protected function registerCommands(array $commands)
    {
        foreach (array_keys($commands) as $command) {
            call_user_func_array([$this, "register{$command}Command"], []);
        }

        $this->commands(array_values($commands));
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerComposerRunCommand()
    {
        $this->app->singleton('command.composer.run', function ($app) {
            return new ComposerRunCommand($app['composer'], $app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerComposerUpdateCommand()
    {
        $this->app->singleton('command.composer.update', function ($app) {
            return new ComposerUpdateCommand($app['composer'], $app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerComposerRemoveCommand()
    {
        $this->app->singleton('command.composer.remove', function ($app) {
            return new ComposerRemoveCommand($app['composer'], $app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerComposerRequireCommand()
    {
        $this->app->singleton('command.composer.require', function ($app) {
            return new ComposerRequireCommand($app['composer'], $app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerComposerInstallCommand()
    {
        $this->app->singleton('command.composer.install', function ($app) {
            return new ComposerInstallCommand($app['composer'], $app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerComposerClearCacheCommand()
    {
        $this->app->singleton('command.composer.clear-cache', function ($app) {
            return new ComposerClearCacheCommand($app['composer'], $app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerComposerDumpAutoloadCommand()
    {
        $this->app->singleton('command.composer.dump-autoload', function ($app) {
            return new ComposerDumpAutoloadCommand($app['composer'], $app['files']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array_values($this->commands);
    }
}
