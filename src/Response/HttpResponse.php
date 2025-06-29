<?php

namespace HttpClient\Response;

/**
 * HTTP Response.
 * 
 * @api
 * @since 1.0.0
 * @version 1.0.0
 * @package http-client
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
class HttpResponse {

    /**
     * Creates a new HTTP response.
     * 
     * @api
     * @final
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param string $protocol The protocol version.
     * @param int $statusCode The status code.
     * @param string $statusText The status text.
     * @param array $headers The headers.
     * @param string $body The body.
     */
    public final function __construct(
        
        public readonly string $protocol,
        public readonly int    $statusCode,
        public readonly string $statusText,
        public readonly array  $headers,
        public readonly string $body
    ) {}
}
