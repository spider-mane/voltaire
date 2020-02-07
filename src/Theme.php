<?php

namespace WebTheory\Voltaire;

use League\Container\Container;
use Psr\Container\ContainerInterface;

class Theme extends Container
{
    /**
     * @var Application
     */
    protected static $instance;

    /**
     * Base path of the framework.
     *
     * @var string
     */
    protected $basePath;

    /**
     *
     */
    public function __construct(string $basePath)
    {
        parent::__construct();

        $this
            ->setBasePath($basePath)
            ->addBaseDefinitions();
    }

    /**
     * Add basic definitions to the container.
     */
    protected function addBaseDefinitions()
    {
        static::setInstance($this);

        $this->share('app', $this);
        $this->share(Theme::class, $this);
        $this->share(ContainerInterface::class, $this);

        return $this;
    }

    /**
     *
     */
    public function bootstrap()
    {
        $this
            ->bindConfiguration()
            ->addProvidersFromConfig()
            ->bindAppToAccessors();

        return $this;
    }

    /**
     *
     */
    public function loadHelpers()
    {
        require dirname(__FILE__) . '/Helpers/functions.php';
    }

    /**
     *
     */
    protected function bindConfiguration()
    {
        $this->share('config', new Config($this->configPath()));

        return $this;
    }

    /**
     *
     */
    protected function addProvidersFromConfig()
    {
        array_map(
            [$this, 'addServiceProvider'],
            $this->get('config')->get('app.providers')
        );

        return $this;
    }

    /**
     * Set the base path for the application.
     *
     * @param string $basePath
     *
     * @return $this
     */
    protected function setBasePath($basePath)
    {
        $this->basePath = realpath($basePath);
        $this->addPathsToContainer();

        return $this;
    }

    /**
     * Bind all of the application paths in the container.
     */
    protected function addPathsToContainer()
    {
        $this->get('path', $this->path());
        $this->get('path.app', $this->appPath());
        $this->get('path.base', $this->basePath());
        $this->get('path.data', $this->dataPath());
        $this->get('path.views', $this->viewPath());
        $this->get('path.routes', $this->routePath());
        $this->get('path.assets', $this->assetsPath());
        $this->get('path.config', $this->configPath());
        $this->get('path.languages', $this->langPath());
        $this->get('path.bootstrap', $this->bootstrapPath());
    }

    /**
     * Get the base path of the installation.
     *
     * @param string $path Optional path to append to the base path.
     *
     * @return string
     */
    public function basePath($path = '')
    {
        return realpath($this->basePath . DIRECTORY_SEPARATOR . $path);
    }

    /**
     * Get the application directory.
     *
     * @param string $path
     *
     * @return string
     */
    public function appPath($path = '')
    {
        return realpath($this->basePath('app') . DIRECTORY_SEPARATOR . $path);
    }

    /**
     * Get the path of the web server root.
     *
     * @param string $path
     *
     * @return string
     */
    public function path($path = '')
    {
        return realpath(get_theme_file_path($path));
    }

    /**
     * Get the resources directory path.
     *
     * @param string $path
     *
     * @return string
     */
    public function dataPath($path = '')
    {
        return realpath($this->basePath('data') . DIRECTORY_SEPARATOR . $path);
    }

    /**
     * Get the bootstrap directory path.
     *
     * @param string $path
     *
     * @return string
     */
    public function bootstrapPath($path = '')
    {
        return realpath($this->basePath('bootstrap') . DIRECTORY_SEPARATOR . $path);
    }

    /**
     * Get the main application configuration directory.
     *
     * @param string $path
     *
     * @return string
     */
    public function configPath($path = '')
    {
        return realpath($this->basePath('config') . DIRECTORY_SEPARATOR . $path);
    }

    /**
     * Get the path to the resources "languages" directory.
     *
     * @param string $path
     *
     * @return string
     */
    public function langPath($path = '')
    {
        return realpath($this->path('languages') . DIRECTORY_SEPARATOR . $path);
    }

    /**
     * Get the path of the asset.
     *
     * @param string $path
     *
     * @return string
     */
    public function assetsPath($path = '')
    {
        return realpath($this->path('assets') . DIRECTORY_SEPARATOR . $path);
    }

    /**
     * Get the path of the asset.
     *
     * @param string $path
     *
     * @return string
     */
    public function viewPath($path = '')
    {
        return realpath($this->path('views') . DIRECTORY_SEPARATOR . $path);
    }

    /**
     * Get the path of the asset.
     *
     * @param string $path
     *
     * @return string
     */
    public function routePath($path = '')
    {
        return realpath($this->path('routes') . DIRECTORY_SEPARATOR . $path);
    }

    /**
     * Get the current application locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->get('config')->get('app.locale');
    }

    /**
     * Set the current application locale.
     *
     * @param  string  $locale
     * @return void
     */
    public function setLocale($locale)
    {
        $this->get('config')->set('app.locale', $locale);
    }

    /**
     * Determine if application locale is the given locale.
     *
     * @param  string  $locale
     * @return bool
     */
    public function isLocale($locale)
    {
        return $this->getLocale() == $locale;
    }

    /**
     * Get the value of instance
     *
     * @return Theme
     */
    public static function getInstance(): Theme
    {
        return static::$instance;
    }

    /**
     * Set the value of instance
     *
     * @param Theme $instance
     *
     * @return self
     */
    protected static function setInstance(Theme $instance)
    {
        static::$instance = $instance;
    }
}
