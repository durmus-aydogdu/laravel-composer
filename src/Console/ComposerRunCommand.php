<?php

namespace DurmusAydogdu\LaravelComposer;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Process\PhpExecutableFinder;

class ComposerRunCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'composer:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run composer command with params';

    /**
     * The composer instance.
     *
     * @var \Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The working path to regenerate from.
     *
     * @var string
     */
    protected $workingPath;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Composer $composer, $files, $workingPath = null)
    {
        parent::__construct();

        $this->composer = $composer;
        $this->files = $files;
        $this->workingPath = $workingPath;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->customCommand($this->argument('name'), $this->option('params'));
    }

    /**
     * Get the composer command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the composer command.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['params', null, InputOption::VALUE_OPTIONAL, 'Composer command params.'],
        ];
    }

    /**
     * Run composer custom command.
     *
     * @param  string  $command
     * @param  string  $params
     * @return void
     */
    public function customCommand($command, $params)
    {
        $this->info("Starting run: composer {$command} {$params}");

        $process = $this->getProcess();

        $process->setCommandLine(trim($this->findComposer().' '. $command.' '.$params));

        $process->run();

        if ($process->getExitCode() === 0) {
            $this->info($process->getIncrementalErrorOutput());
            $this->info($process->getIncrementalOutput());
        }
        else {
            $this->error($process->getErrorOutput());
        }
    }

    /**
     * Get the composer command for the environment.
     *
     * @return string
     */
    protected function findComposer()
    {
        if ($this->files->exists($this->workingPath.'/composer.phar')) {
            return ProcessUtils::escapeArgument((new PhpExecutableFinder)->find(false)).' composer.phar';
        }

        return 'composer';
    }

    /**
     * Get a new Symfony process instance.
     *
     * @return \Symfony\Component\Process\Process
     */
    protected function getProcess()
    {
        return (new Process('', $this->workingPath))->setTimeout(null);
    }
}
