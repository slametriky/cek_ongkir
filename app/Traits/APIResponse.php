<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

trait APIResponse
{
    protected $responseBody = [
        'success' => false,
        'code' => 500,
        'message' => null,
        'meta' => [],
        'data' => null,
    ];

    #Response Handle

    public function successResponse(array $data = null, string $message = 'Request processed successfully'): JsonResponse
    {
        $this->responseBody['success'] = true;
        $this->responseBody['code'] = 200;
        $this->responseBody['message'] = $message;
        $this->responseBody['data'] = $data;


        return response()->json($this->responseBody, $this->responseBody['code']);
    }

    #Request Handle
    #
    public function successRequest(array $data = null, string $message = 'Request processed successfully'): JsonResponse
    {
        $this->responseBody['success'] = true;
        $this->responseBody['code'] = 200;
        $this->responseBody['message'] = $message;
        $this->responseBody['data'] = $data;


        return response()->json($this->responseBody, $this->responseBody['code']);
    }

    public function failRequest(string $message = 'Request not processed'): JsonResponse
    {
        $this->responseBody['success'] = false;
        $this->responseBody['code'] = 410;
        $this->responseBody['message'] = $message;


        return response()->json($this->responseBody, $this->responseBody['code']);
    }


    # Validation Handle
    #
    public function failedValidationInputResponse(Validator $validator, bool $arrSet): JsonResponse
    {
        $dataErrors = $validator->errors()->toArray();
        if ($arrSet) {
            $errors = [];
            foreach ($validator->errors()->toArray() as $key => $value) {
                data_set($errors, $key, $value);
            }
            $dataErrors = $errors;
        }
        $this->responseBody['success'] = false;
        $this->responseBody['data'] = $dataErrors;
        $this->responseBody['message'] = $validator->errors()->first();
        $this->responseBody['code'] = 422;

        return response()->json($this->responseBody, $this->responseBody['code']);
    }


    protected function setResponseMeta(array $meta)
    {
        $this->responseBody['meta'] = array_unique(array_merge($this->responseBody['meta'], $meta), SORT_REGULAR);
    }
}
