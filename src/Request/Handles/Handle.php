<?php

namespace HttpClient\Request\Handles;

use HttpClient\Response\HttpResponse;

/**
 * Request Handle.
 * 
 * @api
 * @final
 * @since 1.0.0
 * @version 1.0.0
 * @package http-client
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
final class Handle extends AbstractHandle {

    /**
     * Waits for the response to be received.
     * 
     * @api
     * @final
     * @override
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @return mixed
     */
    public final function wait(string $responseClass = HttpResponse::class): mixed {

        $result = curl_exec($this->handle);

        curl_close($this->handle);

        if ($result === false) {
            
            $error = curl_error($this->handle);
            $errno = curl_errno($this->handle);

            throw new \RuntimeException("cURL error ({$errno}): {$error}");
        }

        [ $headers, $body ] = explode("\r\n\r\n", $result, 2);
        $headers = explode("\r\n", $headers);
        $statusLine = array_shift($headers);
        [ $protocol, $statusCode, $statusText ] = explode(' ', $statusLine, 3);

        return new $responseClass(
            $protocol,
            $statusCode,
            $statusText,
            $headers,
            $body
        );
    }

    /**
     * Sets an option for the cURL handle.
     * 
     * @api
     * @final
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param int $option The cURL option to set.
     * @param mixed $value The value to set for the option, defaults to true.
     * @return self
     */
    public final function setOption(int $option, mixed $value = true): self {

        curl_setopt($this->handle, $option, $value);

        return $this;
    }
}
