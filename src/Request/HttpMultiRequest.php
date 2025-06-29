<?php

namespace HttpClient\Request;

/**
 * HTTP Multi-Request.
 * 
 * @api
 * @since 1.0.0
 * @version 1.0.0
 * @package http-client
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
class HttpMultiRequest extends HttpAbstractRequest {

    /**
     * The individual requests.
     * 
     * @internal
     * @since 1.0.0
     * @var HttpRequest[] $requests
     */
    private readonly array $requests;

    /**
     * Creates a new HTTP multi-request.
     * 
     * @api
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param HttpRequest ...$requests
     */
    public function __construct(HttpRequest $request, HttpRequest ...$requests) {
        
        $this->requests = [ $request, ...$requests ];
    }

    /**
     * Sets up the request handle.
     * 
     * @final
     * @internal
     * @override
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param Handles\MultiHandle $handle
     * @return void
     */
    protected final function setup(Handles\AbstractHandle $handle): void {

        foreach ($this->requests as $request) {

            $handle->addHandle($request->send());
        }
    }

    /**
     * Creates a new request handle.
     * 
     * @final
     * @static
     * @internal
     * @override
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @return Handles\MultiHandle
     */
    protected static final function newHandle(): Handles\MultiHandle {

        return new Handles\MultiHandle(curl_multi_init());
    }
}
