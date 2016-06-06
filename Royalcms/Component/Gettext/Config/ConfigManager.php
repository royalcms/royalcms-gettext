<?php namespace Royalcms\Component\Gettext\Config;

use Royalcms\Component\Gettext\Config\Models\Config as ConfigModel;
use Royalcms\Component\Gettext\Exceptions\RequiredConfigurationFileException;
use Royalcms\Component\Gettext\Exceptions\RequiredConfigurationKeyException;
use Royalcms\Component\Support\Facades\Config;

class ConfigManager
{
    /**
     * Config model
     *
     * @var ConfigModel
     */
    protected $config;

    /**
     * Package configuration route (published)
     */
    const DEFAULT_PACKAGE_CONFIG = 'gettext::config';

    /**
     * Sets configuration Array
     * 
     * @param Array $config
     */
    public function __construct(Array $config) 
    {
        $this->config = $this->generateFromArray($config);
    }

    /**
     * Returns a new instance of ConfigManager
     * 
     * @param  Array $config
     * @return ConfigManager
     */
    public static function create($config = null)
    {
        if (is_null($config)) {
            // Default package configuration file (published)
            $config = Config::get(static::DEFAULT_PACKAGE_CONFIG);
        }

        if (!$config || !is_array($config)) {
            throw new RequiredConfigurationFileException(
                "You need to publish the package configuration file");
        }

        $manager = new static($config);
        return $manager;
    }

    /**
     * Returns the Config model
     * @return ConfigModel
     */
    public function get() 
    {
        return $this->config;
    }

    /**
     * Creates the configuration container and
     * checks from required fields
     *
     * @param array $config
     * @throws RequiredConfigurationKeyException
     * @return ConfigModel
     */
    protected function generateFromArray(array $config)
    {
        $requiredKeys = array('locale', 'fallback-locale', 'encoding');

        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $config)) {
                throw new RequiredConfigurationKeyException(
                    "Unconfigured required value: $key");
            }
        }

        $container = new ConfigModel();
        $container->setLocale($config['locale'])
            ->setEncoding($config['encoding'])
            ->setFallbackLocale($config['fallback-locale'])
            ->setSupportedLocales($config['supported-locales'])
            ->setDomain($config['domain'])
            ->setTranslationsPath($config['translations-path'])
            ->setProject($config['project'])
            ->setTranslator($config['translator'])
            ->setSourcePaths($config['source-paths'])
            ->setSyncLaravel($config['sync-laravel']);

        return $container;
    }
}
