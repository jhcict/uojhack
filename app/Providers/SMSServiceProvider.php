<?php namespace BByer\Providers;

use Illuminate\Support\ServiceProvider;

class SMSServiceProvider extends ServiceProvider {

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
		$handler = $this->app->make('sms');

		//Ideamart
		$handler->registerSender($this->app->make('ideamart_sms_sender'),'ideamart');
		$handler->registerReceiver($this->app->make('ideamart_sms_receiver'),'ideamart');

		//Twilio
//		$handler->registerSender($this->app->make('twilio_sms_sender'),'twilio');
//
//        Wavecell
//        $handler->registerSender($this->app->make('wavecell_sms_sender'),'wavecell');
	}

}
