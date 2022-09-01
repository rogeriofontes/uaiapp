<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\State;
use App\Store;
use App\Address;
use App\ProductSubCategory;
use App\ProductHasInterest;

class AjaxController extends Controller
{
    public function __construct()
    {

    }

    public function getCep(Request $request)
    {
        $input = $request->all();

        $wsCep      = cep($input['cep']);
        $arrayCep   = $wsCep->toArray();
        $json  =  $arrayCep->result();

        $json['resultado'] = 0;

        if($json){

            if($json['logradouro'] == '' && $json['bairro'] == ''){
                $json['resultado'] = 2;
            }else{
                $json['resultado'] = 1;
            }

            $json['cidade'] = $json['localidade'];
            unset($json['localidade']);

            //verificando se a cidade já existe o cadastro, caso não exista, salvando ela.
            $city = City::where('city', $json['cidade'])->whereHas('getState', function($query) use($json){
                $query->where('state', $json['uf']);
            })->first();

            if($city == null){
                $state = State::whereState($json['uf'])->first();

                if($state == null){
                    $state = new State([
                        'country_id' => 1,
                        'state'      => $json['uf']
                    ]);
                    $state->save();
                }

                $city = new City([
                    'state_id' => $state->id,
                    'city'     => $json['cidade']
                ]);
                $city->save();
            }

            $json['city_id'] = $city->id;
    
        }

        return $json;
    }


    public function getCompany(Request $request)
    {
        $input = $request->all();
        
        return Store::whereHas('getPerson', function($query) use($input){
            $query->where('cpf_cnpj', $input['cpf_cnpj']);
        })->first();

    }

    // Buscar subcategorias
    public function getProductSubcategories(Request $request)
    {
        $productSubcategories = ProductSubCategory::select(['id', 'subcategory'])->where('product_category_id', $request->input('product_category_id'))->get();
        
        return json_encode($productSubcategories);
    }

    public function updateInterestStatus(Request $request)
    {
        $input = $request->all();
        $productHasInterest = ProductHasInterest::find($input['product_has_interest_id']);

        $productHasInterest->fill(['status' => $input['status']])->save();

        return json_encode(true);
    }
}
