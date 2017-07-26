<?php

namespace USaq\App\ServiceProvider;

use USaq\App\ServiceProvider\Providers\SettingsProvider;

/**
 * Maintains and group all service providers.
 */
class ServiceProviderManager
{
    /**
     * @var ServiceProviderInterface[]
     */
    protected $providers;

    public function __construct()
    {
        // Add SettingProvider by default to the list of providers.
        $this->addServiceProvider(new SettingsProvider());
    }

    /**
     * Add new service provider.
     *
     * @param ServiceProviderInterface $provider
     */
    public function addServiceProvider(ServiceProviderInterface $provider)
    {
        $this->providers[] = $provider;
    }

    /**
     * Add a list of service providers.
     *
     * @param ServiceProviderInterface[] $providers
     */
    public function addServiceProviders(array $providers)
    {
        foreach ($providers as $provider) {
            if (!$provider instanceof ServiceProviderInterface) {
                throw new \RuntimeException('Provider not implements ServiceProviderInterface');
            }

            $this->addServiceProvider($provider);
        }
    }

    /**
     * @return ServiceProviderInterface[]
     */
    public function getServiceProviders()
    {
        return $this->providers;
    }
}