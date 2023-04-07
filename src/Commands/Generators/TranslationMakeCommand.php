<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Commands\Traits\Console;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class TranslationMakeCommand extends GeneratorCommand
{
    use Console;

    /**
     * @var string
     */
    private $lang;

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Translation';

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $options = parent::getOptions();

        $options[] = ['lang', null, InputOption::VALUE_REQUIRED, 'Create the folder with a lang code'];

        return $options;
    }

    /**
     * @return bool|null
     */
    public function handle()
    {
        $this->lang = $this->option('lang');

        if (!$this->lang) {
            $lang = $this->ask('Please, write your language code (for example en, fr, de)');

            if(!$lang){
                $this->error('Translation file cannot be created without language');

                return false;
            }

            $this->lang = $lang;
        }

        return parent::handle();
    }

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:translation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new translation file';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__.'/stubs/translation.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $this->getShipNamespace().'\Translations\\'.$this->lang;
    }
}
