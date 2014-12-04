<?php
namespace BByer\System\SMS\Wavecell\Sender\Broker;

use BByer\System\SMS\Contracts\Sender\ServiceBrokerInterface;

class ServiceBroker implements ServiceBrokerInterface
{

    protected $server_url;

    protected $app_id;

    protected $sub_app_id;

    protected $password;

    protected $app;

    /**
     * @param $server
     * @param $app
     * @param $password
     */
    public function __construct($server = null, $app = null, $password = null)
    {
        $this->server_url = $server;
        $this->app_id = $app;
        $this->sub_app_id = $app . '_std';
        $this->password = $password;
        $this->app = app();
    }

    /**
     * Magic Get Method to replace Native Access Methods
     */
    public function __get($name)
    {
        return $this->{$name};
    }

    /**
     *
     * Magic Set Method to replace Native Access Methods
     */
    public function __set($name, $value = null)
    {
        return $this->{$name} = $value;
    }

    public function refresh($appId)
    {
//        $configLoader = $this->app->make('BByer\System\ConfigLoader\Contracts\ConfigLoader');
        $configLoader = $this->app->make('BByer\System\ConfigLoader\MongoConfigLoader');
        $configLoader->setApplication($appId);
        $provider = $this->app['config']->get('system.' . $appId . '.sms.providers.wavecell.default');
        $config = $this->app['config']->get('system.' . $appId . '.sms.providers.wavecell.' . $provider);
        \Log::info('config');
        \Log::info($config);

        $this->server_url = $config['server_url'];
        $this->password = $config['password'];
        $this->app_id = $config['accountId'];
        $this->sub_app_id = $config['subAccountId'];

        return $this;
    }
}
