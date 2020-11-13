<?php

namespace App\Exceptions;

use Exception;

class AppException extends Exception
{
    private $httpCode;
    private $errorMessage;
    private $errorCode;
    private $validationErrors;

    public function __construct($message, $code, $validationErrors = null)
    {
        $this->httpCode = $code;
        $this->errorMessage = __("app_errors.{$message}.message");
        $this->errorCode = __("app_errors.{$message}.code");
        $this->validationErrors = $validationErrors;
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        return response()->json(
            [
                'error' => [
                    'code'    => (int) $this->errorCode,
                    'message' => $this->errorMessage,
                    'errors'  => $this->validationErrors,
                ],
            ],
            $this->httpCode
        );
    }
}