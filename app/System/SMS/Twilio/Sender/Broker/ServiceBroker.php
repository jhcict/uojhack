<?php
namespace BByer\System\SMS\Twilio\Sender\Broker;

use BByer\System\SMS\Contracts\Sender\ServiceBrokerInterface;

class ServiceBroker implements ServiceBrokerInterface
{

    protected $app_id;

    protected $app_secret;

    protected $from;

    protected $app;

    protected $provider;

    /**
     * @param $server
     * @param $app
     * @param $password
     */
    public function __construct($provider=null,$app = null, $password = null,$from=null)
    {
        $this->provider = $provider;
        $this->app_id = $app;
        $this->app_secret = $password;
        $this->from = $from;
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
        $configLoader = $this->app->make('BByer\System\ConfigLoader\Contracts\ConfigLoader');
//        $configLoader = $this->app->make('BByer\System\ConfigLoader\MongoConfigLoader');
        $configLoader->setApplication($appId);
        $provider = $this->app['config']->get('system.' . $appId . '.sms.providers.twilio.default');
        $provider = $provider?$provider:$this->provider;

        $config = $this->app['config']->get('system.' . $appId . '.sms.providers.twilio.' . $provider);

        $this->app_secret = $config['app_secret'];
        $this->app_id = $config['app_id'];
        $this->from = $config['from'];

        return $this;
    }
}
