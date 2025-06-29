<?php

namespace HttpClient\Request;

/**
 * Abstract HTTP Request.
 * 
 * @api
 * @abstract
 * @since 1.0.0
 * @version 1.0.0
 * @package http-client
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
abstract class HttpAbstractRequest {

    /**
     * Sends the request off but does not wait for the response.
     * 
     * @api
     * @final
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @return Handles\AbstractHandle
     */
    public final function send(): Handles\AbstractHandle {

        $this->setup($handle = static::newHandle());

        $handle->start();

        return $handle;
    }

    /**
     * Sets up the request handle.
     * 
     * @internal
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param Handles\AbstractHandle $handle
     * @return void
     */
    protected function setup(Handles\AbstractHandle $handle): void {}

    /**
     * Creates a new request handle.
     * 
     * @static
     * @abstract
     * @internal
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @return Handles\AbstractHandle
     */
    protected static abstract function newHandle(): Handles\AbstractHandle;
}
