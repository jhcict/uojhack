<?php

namespace BByer\System\USSD\Ideamart\Maker;

use Illuminate\Contracts\Foundation\Application;
use BByer\Source\Applications\ApplicationRepository;
use BByer\System\ConfigLoader\Contracts\ConfigLoader;
use BByer\System\Session\Contracts\SessionHandler;
use BByer\System\USSD\Ideamart\Sender\Broker\ServiceBroker;

/**
 * Class MessageTranslator
 * @package BByer\System\USSD\Ideamart\Maker
 */
class MessageTranslator
{


    /**
     * @var \BByer\System\USSD\Ideamart\Session\Contracts\SessionHandler
     */
    protected $session;

    /**
     * @var \Illuminate\Contracts\Config\Config
     */
    protected $config;

    protected $configLoader;

    protected $serviceBroker;

    /**
     * @param \BByer\System\Session\Contracts\SessionHandler|\BByer\System\USSD\Ideamart\Session\Contracts\SessionHandler $sessionHandler
     * @param \Illuminate\Contracts\Foundation\Application                                                                $application
     * @param \BByer\System\ConfigLoader\Contracts\ConfigLoader                                                           $configLoader
     * @param \BByer\System\USSD\Ideamart\Sender\Broker\ServiceBroker                                                     $serviceBroker
     */
    public function __construct(SessionHandler $sessionHandler,
                                Application $application,
                                ConfigLoader $configLoader,
                                ServiceBroker $serviceBroker)
    {
        $this->session = $sessionHandler;
        $this->config = $application->make('config');
        $this->configLoader = $configLoader;
        $this->serviceBroker = $serviceBroker;
    }


    /**
     * @param array                                                $request
     * @param \BByer\System\USSD\Ideamart\Maker\Parser         $parser
     * @param \BByer\Source\Applications\ApplicationRepository $applicationRepository
     */
    public function translate(array $request,
                              Parser $parser,
                              ApplicationRepository $applicationRepository)
    {
        $message = $request['message'];
        $this->session->setParameters($request);
        $this->session->setAppId($applicationRepository->searchApplication('ideamart', $request['applicationId'])->app_id);
        $this->configLoader->setApplication();
        $this->updateService();
        $menu = $parser->getMenuPlain();
        $message = $this->messageConverter($message);
        $this->messageIterator($menu['options'], $message, $parser);
    }


    /**
     * @param array                                        $menu
     * @param array                                        $message
     *
     * @param \BByer\System\USSD\Ideamart\Maker\Parser $parser
     *
     * @return string
     */
    private function messageIterator(array $menu, array $message, Parser $parser)
    {

        \Log::info('into iterator');
        if (empty($message)) {
            if ($parser->getMenuPlain()['type'] == 'master_menu') {
                $this->session->setOperation("mt-cont");
            }
            return "";

        }
        foreach ( $message as $key ) {
            \Log::info('into iterator keys');
            if ($this->session->isAction()) {
                $option = array_pop($message);
                $this->session->setOption($option);
                $this->session->setOperation("mt-cont");
            } //check key, go in if set, otherwise just move forward
            elseif (isset($menu[$key]) && ! $this->session->isAction()) {
                if ($menu[$key]['type'] == "sub_menu") {
                    $operation = $menu[$key]['response'];
                    $this->session->setOperation($operation);
                    $this->session->setMenuPath($this->session->getMenuPath() . '.options.' . $key . '.sub_menu');
                    array_shift($message);

                    return $this->messageIterator($menu[$key]['sub_menu']['options'], $message, $parser);
                } elseif ($menu[$key]['type'] == "message") {
                    $operation = $menu[$key]['response'];
                    $this->session->setOption($key);
                    $this->session->setOperation($operation);
                    $this->session->setMenuPath($this->session->getMenuPath() . '.options.' . $key);
                } else {
                    $option = array_pop($message);
                    $this->session->setOption($option);
                    if (isset($menu[$key])) {
                        $operation = $menu[$key]['response'];
                        $this->session->setOperation($operation);
                    }
                }
            }
        }

    }


    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param string $message
     *
     * @return array
     */
    private function messageConverter($message = "")
    {

        $code = $this->config->get('system.' . $this->session->getAppId() . '.ussd.code');
        $count = 1;
        $message = str_replace($code, "", $message, $count);
        $message = explode("*", $message);
        $message[sizeof($message) - 1] = trim($message[sizeof($message) - 1], '#');

        return array_filter($message);
    }

    private function updateService()
    {

        $app_id = $this->session->getAppId();


        $provider = $this->config->get('system.' . $app_id . '.ussd.provider');
        $config = $this->config->get('system.' . $app_id . '.ussd.providers.' . $provider);

        $this->serviceBroker->app_id = $config['app_id'];
        $this->serviceBroker->server_url = $config['server'];
        $this->serviceBroker->password = $config['app_secret'];
    }
}