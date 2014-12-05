<?php namespace BByer\Http\Controllers;

use BByer\Http\Requests;
use Illuminate\Contracts\Foundation\Application;

class UserRequestController extends Controller
{

    protected $app;

    public function __construct(Application $application)
    {
        $this->app = $application;

    }

    public function getRequest()
    {
        $request = $this->app->make('sms')->receiver('ideamart')->receive(\Input::all());


        $message = $request->getMessage();


        $request = $request->getRequest();
        app('sms')->sender('ideamart')->setMessage('testing message' . $message)->addAddress('tel:94777743489')
            ->refresh('APP_000001')
            ->send();

        \Log::info($request);
        \Log::info($message);


        $message = explode(' ', $message);

        switch ($message[1]) {
            case "subscribe": {
//                $message[2] remains name




            }
        }

        return '';

    }


    public function getUssdRequest()
    {
        app('ideamart_ussd')->setCustomOperation('mt-cont')->handle(\Input::all())->makeResponse();
    }


}