<?php

namespace App\Microservice\Exceptions;

use Exception;

class MicroserviceException extends Exception
{

    protected $message = 'Unexpected error';
    protected $code = 0;

    /**
     * Result of request.
     *
     * @var mixed
     */
    protected $knownResult;

    /**
     * Initialization result flag.
     *
     * @var bool
     */
    protected bool $resultIsInitialized = false;

    /**
     * Result setter.
     *
     * @param $result
     * @return $this
     */
    public function setResult($result): MicroserviceException
    {
        $this->knownResult = $result;
        $this->resultIsInitialized = true;

        return $this;
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @return array
     */
    public function render(): array
    {
        return $this->createResponseContent();
    }

    /**
     * Create response data.
     *
     * @return array
     */
    protected function createResponseContent(): array
    {
        $content = [];

        if ($this->resultIsInitialized) {
            $content['result'] = $this->knownResult;
        }

        $content['errors'] = [];
        $content['errors'][] = $this->createErrorBody();

        return $content;
    }

    /**
     * Create error body.
     *
     * @return array
     */
    protected function createErrorBody(): array
    {
        return [
            'code' => $this->getCode(),
            'mess' => $this->getMessage(),
        ];
    }

    /**
     * Get the known result as exception's context information.
     *
     * @return array
     */
    public function context(): array
    {
        if ($this->resultIsInitialized) {
            $context = ['result' => $this->knownResult];
        } else {
            $context = [];
        }

        return $context;
    }
}
