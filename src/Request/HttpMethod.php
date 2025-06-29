<?php

namespace HttpClient\Request;

/**
 * HTTP Method.
 * 
 * @api
 * @since 1.0.0
 * @version 1.0.0
 * @package http-client
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
enum HttpMethod {

    case GET;

    case HEAD;
    
    case POST;

    case PUT;
    
    case PATCH;
    
    case DELETE;

    case OPTIONS;
}
