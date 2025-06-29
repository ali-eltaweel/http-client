<?php

namespace HttpClient\Request\Handles;

/**
 * Abstract Request Handle.
 * 
 * @internal
 * @abstract
 * @since 1.0.0
 * @version 1.0.0
 * @package http-client
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
abstract class AbstractHandle {

    /**
     * Creates a new request handle.
     * 
     * @api
     * @final
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param mixed $handle
     */
    public final function __construct(protected readonly mixed $handle) {}

    /**
     * Sends the request off but does not wait for the response.
     * 
     * @api
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @return void
     */
    public function start(): void {}

    /**
     * Waits for the response to be received.
     * 
     * @api
     * @abstract
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @return mixed
     */
    public abstract function wait(): mixed;
}
