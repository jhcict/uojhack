<?php

namespace BByer\System\SMS\Ideamart\Receiver;

use Illuminate\Contracts\Foundation\Application;
use BByer\System\SMS\Contracts\Receiver\ValidatorInterface;

class RequestValidator implements ValidatorInterface
{

    protected $rules;

    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->rules = [
            'message'       => 'required|min:4|max:512',
            'requestId'     => 'required|numeric',
            'encoding'      => 'required|max:22',
            'sourceAddress' => 'required|max:73|min:12',
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
            // throw new \Exception("Request");
        } else {
            return $request;
        }
    }
}
