<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\RajaOngkir\Ongkir;

class RajaOngkirController extends Controller
{
    public function getProvinces(Request $request)
    {        
        try {

            if($request->get('id')){

                $data = Ongkir::find(['province_id' => $request->id])->province()->get();
                
                $data = $data->isEmpty() ? [] : $data->toArray();
                
                return $this->successResponse($data);

            } else {

                return $this->failRequest('Url is not valid');
            } 

            
        } catch (Exception $exception) {
            return $this->failRequest($exception->getMessage());
        }
    }

    public function getCities(Request $request)
    {        
        try {

            if($request->get('id')){

                $data = Ongkir::find(['city_id' => $request->id])->city()->get();

                $data = $data->isEmpty() ? [] : $data->toArray();
                
                return $this->successResponse($data);
                
            } else {
                return $this->failRequest('Url is not valid');
            } 
            
        } catch (Exception $exception) {
            return $this->failRequest($exception->getMessage());
        }
    }
}
