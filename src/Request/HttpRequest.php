<?php

namespace HttpClient\Request;

use Closure;

/**
 * HTTP Request.
 * 
 * @api
 * @since 1.0.0
 * @version 1.0.0
 * @package http-client
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
class HttpRequest extends HttpAbstractRequest {

    /**
     * Creates a new HTTP request.
     * 
     * @api
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param string $url
     * @param HttpMethod $method
     * @param bool $showPorgress
     * @param ?((int $downloadSize, int $downloaded, int $uploadSize, int $uploaded):void)  $progressCallback
     * @param int|null $timeoutMillis
     * @param array $headers
     * @param array $query
     * @param array $postFields
     */
    public function __construct(
        
        public readonly string $url,
        public readonly HttpMethod $method = HttpMethod::GET,
        public bool $showPorgress = false,
        public ?Closure $progressCallback = null,
        public readonly ?int $timeoutMillis = null,
        public readonly array $headers = [],
        public readonly array $query = [],
        public readonly array $postFields = [],
    ) {}

    /**
     * Sets up the request handle.
     * 
     * @final
     * @internal
     * @override
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param Handles\Handle $handle
     * @return void
     */
    protected final function setup(Handles\AbstractHandle $handle): void {

        $handle->setOption(CURLOPT_URL, $this->url);

        switch ($this->method) {
            case HttpMethod::GET:
                $handle->setOption(CURLOPT_HTTPGET);
                break;
            case HttpMethod::POST:
                $handle->setOption(CURLOPT_POST);
                break;
            case HttpMethod::PUT:
            case HttpMethod::PATCH:
            case HttpMethod::DELETE:
            case HttpMethod::OPTIONS:
                $handle->setOption(CURLOPT_CUSTOMREQUEST, $this->method->name);
                break;
        }
        
        $handle->setOption(CURLOPT_RETURNTRANSFER)->setOption(CURLOPT_HEADER);

        if ($this->timeoutMillis) {
            
            $handle->setOption(CURLOPT_TIMEOUT_MS, $this->timeoutMillis);
        }

        if (count($this->headers)) {

            $formattedHeaders = [];

            foreach ($this->headers as $key => $value) {
                
                $formattedHeaders[] = "$key: $value";
            }

            $handle->setOption(CURLOPT_HTTPHEADER, $formattedHeaders);
        }

        if (count($this->query)) {
            
            $queryString = http_build_query($this->query);
            $handle->setOption(CURLOPT_URL, $this->url . '?' . $queryString);
        }

        if (count($this->postFields)) {
            
            $handle->setOption(CURLOPT_POSTFIELDS, $this->postFields);
        }

        $handle->setOption(CURLOPT_NOPROGRESS, !$this->showPorgress && is_null($this->progressCallback));
        if ($this->progressCallback) {

            $handle->setOption(CURLOPT_XFERINFOFUNCTION, function ($ch, $download_size, $downloaded, $upload_size, $uploaded) {

                ($this->progressCallback)($download_size, $downloaded, $upload_size, $uploaded);
            });
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
     * @return Handles\Handle
     */
    protected static final function newHandle(): Handles\Handle {

        return new Handles\Handle(curl_init());
    }
}
