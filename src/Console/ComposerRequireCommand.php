<?php

namespace DurmusAydogdu\LaravelComposer;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\PhpExecutableFinder;

class ComposerRequireCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'composer:require';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add new package to the composer.json file';

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
        $this->installPackage($this->option('package'));
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['package', null, InputOption::VALUE_OPTIONAL, 'Package name, example: "--package=durmus-aydogdu/laravel-resource"'],
        ];
    }

    /**
     * Install package with composer require.
     *
     * @param string $packageName
     * @return void
     */
    public function installPackage($packageName)
    {
        $this->info("Starting ".$packageName." installation");
        
        $process = $this->getProcess();
        
        $process->setCommandLine(trim($this->findComposer().' require '.$packageName));
        
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

    /**
     * Set the working path used by the class.
     *
     * @param  string  $path
     * @return $this
     */
    public function setWorkingPath($path)
    {
        $this->workingPath = realpath($path);

        return $this;
    }
}
