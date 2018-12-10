<?php

namespace Aldemeery\ContextualResponse;

use Aldemeery\ContextualResponse\ContextualResponseInterface;
use Aldemeery\ContextualResponse\ResponseTypeNotSupportedException;
use Illuminate\Container\Container;

abstract class Response implements ContextualResponseInterface
{
    /**
     * The response value.
     *
     * @var mixed.
     */
    protected $response;

    /**
     * Contructor.
     *
     * @param mixed $response The response value.
     */
    final public function __construct($response)
    {
        $this->response = $response;
    }

    /**
     * Respond with a relevant response.
     *
     * @return mixed
     */
    public function respond()
    {
        $request = Container::getInstance()->make('request');

        if ($request->expectsJson()) {
            $response = $this->toJson();
        } elseif ($request->wantsXml()) {
            $response = $this->toXml();
        } elseif ($request->wantsHtml()) {
            $response = $this->toHtml();
        } elseif ($request->wantsPdf()) {
            $response = $this->toPdf();
        } else {
            $response = $this->fallback();
        }

        return $response;
    }

    /**
     * Fallback response when no 'Accept' header value is defined.
     *
     * @return mixed
     */
    protected function fallback()
    {
        return $this->response;
    }

    /**
     * Invoked when inaccessible methods are called.
     *
     * @param string $method The method called
     * @param array  $args   The arguments passed to the called method.
     *
     * @return mixed.
     */
    public function __call($method, $args)
    {
        // phpcs:disable
        if ($method === 'toJson') {
            throw new ResponseTypeNotSupportedException('The request is asking for a JSON response. Implement the "toJson" mehtod to support JSON responses.');
        } elseif ($method === 'toHtml') {
            throw new ResponseTypeNotSupportedException('The request is asking for an HTML response. Implement the "toHtml" mehtod to support HTML responses.');
        } elseif ($method === 'toXml') {
            throw new ResponseTypeNotSupportedException('The request is asking for an XML response. Implement the "toXml" mehtod to support XML responses.');
        } elseif ($method === 'toPdf') {
            throw new ResponseTypeNotSupportedException('The request is asking for a PDF response. Implement the "toPdf" mehtod to support PDF responses.');
        }
        // phpcs:enable
    }
}
