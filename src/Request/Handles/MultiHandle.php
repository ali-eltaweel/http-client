<?php

namespace HttpClient\Request\Handles;

use Generator;

/**
 * Multi-Request Handle.
 * 
 * @api
 * @final
 * @since 1.0.0
 * @version 1.0.0
 * @package http-client
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
final class MultiHandle extends AbstractHandle {

    /**
     * The individual handles.
     * 
     * @internal
     * @since 1.0.0
     * @var Handle[] $handles
     */
    private array $handles = [];

    /**
     * The number of the running handles.
     * 
     * @internal
     * @since 1.0.0
     * @var int $running
     */
    private int $running = 0;

    /**
     * Sends the request off but does not wait for the response.
     * 
     * @api
     * @final
     * @override
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @return void
     */
    public final function start(): void {

        do {
            
            $status = curl_multi_exec($this->handle, $this->running);
        
        } while ($status === CURLM_CALL_MULTI_PERFORM);
    }

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
    public final function wait(float $timeout = 1.0): Generator {

        do {

            $this->start();

            curl_multi_select($this->handle, $timeout);

            while ($info = curl_multi_info_read($this->handle)) {
                
                $handle = $info['handle'];
                $response = curl_multi_getcontent($handle);

                yield $response;

                curl_multi_remove_handle($this->handle, $handle);
            }

        } while ($this->running > 0);
    }

    /**
     * Adds a handle to the multi-handle.
     * 
     * @api
     * @final
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param Handle $handle The handle to add.
     * @return self
     */
    public final function addHandle(Handle $handle): self {

        $this->handles[] = $handle;

        curl_multi_add_handle($this->handle, $handle->handle);

        return $this;
    }
}
