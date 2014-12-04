<?php

namespace BByer\System\USSD\Ideamart\Maker;

use BByer\Source\Applications\ApplicationRepository;

class Producer
{

    protected $parser;

    protected $translator;

    protected $responder;

    protected $request;

    /**
     * @param \BByer\System\USSD\Ideamart\Maker\Parser            $parser
     * @param \BByer\System\USSD\Ideamart\Maker\MessageTranslator $translator
     * @param \BByer\System\USSD\Ideamart\Maker\Responder         $responder
     */
    public function __construct(Parser $parser,
                                MessageTranslator $translator,
                                Responder $responder
    )
    {
        $this->parser = $parser;
        $this->translator = $translator;
        $this->responder = $responder;
    }

    public function setRequest(array $request)
    {
        $this->request = $request;

        return $this;
    }

    public function loadSetup()
    {
        return $this;
    }

    public function translateMessage(ApplicationRepository $applicationRepository)
    {
        $this->translator->translate($this->request, $this->parser,$applicationRepository);

        return $this;
    }

    public function makeMessage()
    {
        return $this->responder->produceResponse($this->parser, $this->translator);
    }

    public function __toString()
    {
        return $this->responder->getMessage();
    }
}
