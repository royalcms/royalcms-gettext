<?php namespace Royalcms\Component\Gettext\Commands;

use Royalcms\Component\Console\Command;
use Royalcms\Component\Gettext\FileSystem;
use Royalcms\Component\Gettext\Config\ConfigManager;

class BaseCommand extends Command
{

    /**
     * Filesystem helper
     * @var \Royalcms\Component\Gettext\FileSystem
     */
    protected $fileSystem;

    /**
     * Package configuration data
     * @var Array
     */
    protected $configuration;    

    /**
     * Create a new command instance. 
     *
     * @return \Royalcms\Component\Gettext\Commands\BaseCommand
     */
    public function __construct()
    {
        $configManager = ConfigManager::create();
        
        $this->fileSystem = new FileSystem($configManager->get(),
            app_path(),
            storage_path()
        );

        $this->configuration = $configManager->get();

        parent::__construct();
    }

}
