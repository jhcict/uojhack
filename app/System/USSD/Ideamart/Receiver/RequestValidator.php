<?php

namespace BByer\System\USSD\Ideamart\Receiver;


use Illuminate\Contracts\Foundation\Application;

class RequestValidator
{

    protected $rules;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->rules = [
            'message'       => 'required|min:1|max:512',
            'requestId'     => 'required|numeric',
            'encoding'      => 'required|max:22',
            'sourceAddress' => 'required|max:73',
            'version'       => 'required|size:3'
        ];
    }

    public function validate(array $request)
    {
        $validator = $this->app['validator']->make(
            $request,
            $this->rules
        );

        if ($validator->fails()) {
            \Log::info($validator->failed());
            \Log::info($request);
        } else {
            return $request;
        }
    }
}
