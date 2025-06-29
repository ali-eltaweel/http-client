<?php

namespace HttpClient\Request;

use Closure;
use InvalidArgumentException;

/**
 * HTTP Request Builder.
 * 
 * @api
 * @final
 * @since 1.0.0
 * @version 1.0.0
 * @package http-client
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
final class HttpRequestBuilder {

    private ?string $url = null;
    private HttpMethod $method = HttpMethod::GET;
    private bool $showPorgress = false;
    private ?Closure $progressCallback = null;
    private ?int $timeoutMillis = null;
    private array $headers = [];
    private array $query = [];
    private array $postFields = [];

    public final function reset(): void {
        
        $this->url = null;
        $this->method = HttpMethod::GET;
        $this->showPorgress = false;
        $this->progressCallback = null;
        $this->timeoutMillis = null;
        $this->headers = [];
        $this->query = [];
        $this->postFields = null;
    }

    public final function setUrl(string $url): self {
        
        $this->url = $url;
        
        return $this;
    }

    public final function setMethod(HttpMethod $method): self {
        
        $this->method = $method;
        
        return $this;
    }

    public final function showProgress(bool $show = true): self {
        
        $this->showPorgress = $show;
        
        return $this;
    }

    public final function setProgressCallback(?Closure $callback): self {
        
        $this->progressCallback = $callback;
        
        return $this;
    }

    public final function setTimeoutMillis(?int $timeoutMillis): self {
        
        $this->timeoutMillis = $timeoutMillis;
        
        return $this;
    }

    public final function setHeaders(array $headers): self {
        
        $this->headers = $headers;
        
        return $this;
    }

    public final function header(string $name, string $value): self {
        
        $this->headers[$name] = $value;
        
        return $this;
    }

    public final function setQuery(array $query): self {
        
        $this->query = $query;
        
        return $this;
    }

    public final function query(string $name, string $value): self {
        
        $this->query[$name] = $value;
        
        return $this;
    }

    public final function setPostFields(?array $postFields): self {
        
        $this->postFields = $postFields;
        
        return $this;
    }

    public final function postField(string $name, mixed $value): self {
        
        $this->postFields[$name] = $value;
        
        return $this;
    }

    public final function build(): HttpRequest {
        
        if (is_null($this->url)) {
            
            throw new InvalidArgumentException('URL must be set before building the request.');
        }
        
        return new HttpRequest(
            
            url: $this->url,
            method: $this->method,
            showPorgress: $this->showPorgress,
            progressCallback: $this->progressCallback,
            timeoutMillis: $this->timeoutMillis,
            headers: $this->headers,
            query: $this->query,
            postFields: $this->postFields,
        );
    }

    public static final function instance(): self {
        
        return new self();
    }
}
