<?php namespace Intagono\Openpay;

use Exception;
use OpenpayApiAuthError;
use OpenpayApiConnectionError;
use OpenpayApiError;
use OpenpayApiRequestError;
use OpenpayApiTransactionError;

trait OpenpayExceptionTrait {

    /**
     * Determine if the given exception is an OpenpayApiError exception.
     *
     * @param  Exception $e
     * @return bool
     */
    public function isOpenPayException(Exception $e)
    {
        return $e instanceof OpenpayApiError;
    }

    /**
     * Render the given OpenpayApiError.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  OpenpayApiError $e
     * @return ApiResponse
     */
    public function renderOpenPayException($request, OpenpayApiError $e)
    {
        if ($e instanceof OpenpayApiTransactionError)
        {
            $message = 'ERROR en la transacción: ' . $e->getMessage()
                     . ' [código de error: ' . $e->getErrorCode()
                     . ', categoría de error: ' . $e->getCategory()
                     . ', código HTTP: ' . $e->getHttpCode()
                     . ', id petición: ' . $e->getRequestId() . ']';
        }
        elseif ($e instanceof OpenpayApiRequestError)
        {
            $message = 'ERROR en la petición: ' . $e->getMessage();
        }
        elseif ($e instanceof OpenpayApiConnectionError)
        {
            $message = 'ERROR en la conexión al API: ' . $e->getMessage();
        }
        elseif ($e instanceof OpenpayApiAuthError)
        {
            $message = 'ERROR en la autenticación: ' . $e->getMessage();
        }
        else
        {
            $message = 'ERROR en el API: ' . $e->getMessage();
        }

        if ($request->ajax() || $request->wantsJson())
        {
            return response($message, 400);
        }
        else
        {
            return response($message, 400);
            // return back()->withInput()->with('error', $message);
        }
    }

}