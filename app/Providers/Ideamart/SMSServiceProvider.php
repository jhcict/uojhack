<?php namespace BByer\Providers\Ideamart;

use Illuminate\Support\ServiceProvider;
use BByer\System\SMS\Ideamart\Receiver\Receiver;
use BByer\System\SMS\Ideamart\Receiver\RequestValidator;
use BByer\System\SMS\Ideamart\Sender\Broker\AddressBroker;
use BByer\System\SMS\Ideamart\Sender\Broker\MessageBroker;
use BByer\System\SMS\Ideamart\Sender\Broker\ServiceBroker;
use BByer\System\SMS\Ideamart\Sender\RequestFormatter;
use BByer\System\SMS\Ideamart\Sender\ResponseHandler;
use BByer\System\SMS\Ideamart\Sender\Sender;

class SMSServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind('ideamart_message_broker', function () {
            return new MessageBroker("");
        });
        $this->app->bind('ideamart_address_broker', function () {
            return new AddressBroker();
        });
        $this->app->bind('ideamart_service_broker',function(){
            return new ServiceBroker();
        });
        $this->app->bind('ideamart_request_formatter',function(){
           return new RequestFormatter();
        });
        $this->app->bind('ideamart_response_handler',function(){
           return new ResponseHandler();
        });
        $this->app->bind('ideamart_sms_sender', function () {

            $message = app()->make('ideamart_message_broker');
            $address = app()->make('ideamart_address_broker');
            $service = app()->make('ideamart_service_broker');
            $formatter = app()->make('ideamart_request_formatter');
            $handler = app()->make('ideamart_response_handler');
            $session = app()->make('BByer\System\Session\Contracts\SessionHandler');

            return new Sender($service,$address,$message,$formatter,$handler,$session);
        });

        $this->app->bind('ideamart_sms_validator',function(){
            return new RequestValidator(app());
        });
        $this->app->bind('ideamart_sms_formatter','BByer\System\SMS\Ideamart\Receiver\RequestFormatter');

        $this->app->bind('ideamart_sms_receiver',function(){
            $formatter = $this->app->make('ideamart_sms_formatter');
            $validator = $this->app->make('ideamart_sms_validator');
            return new Receiver($formatter,$validator);
        });
    }

    public function provides()
    {
        return ['ideamart_sms_sender', 'ideamart_sms_receiver'];
    }

}
