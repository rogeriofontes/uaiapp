<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helper;
use Validator;
use View;
use Session;
use Form;
use Storage;
use App\ProductHasInterest;

class InterestController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->pagina        = "Produtos";
        $this->breadcrumb[] = ['route' => \Route::getCurrentRoute()->getPrefix() . '/' . $this->route, 'pagina' => $this->pagina];

        View::share([
            'title'         => $this->pagina,
            'routeFather'   => $this->route,
        ]);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(isset($_GET['draw'])){

            $array = array();
            $collumns = ['product_has_interest_id', 'products_name', 'stores_name', 'product_has_interests_status', 'product_has_interests_date'];

            $orderColumn = $_GET['order'][0]['column'];
            $oderDir     = $_GET['order'][0]['dir'];
            $start       = $_GET['start'];
            $length      = $_GET['length'];
            $search      = $_GET['search']['value'];

            $data = ProductHasInterest::orderByRaw($collumns[$orderColumn] . ' ' . $oderDir);
            
            $whereRaw = "";
            if($search != ""){
                $whereRaw = '(products.name LIKE "%' .$search. '%" OR 
                             people.name LIKE "%'.$search.'%" OR
                             user.name LIKE "%' .$search. '%"
                             )';     
                $data->whereRaw($whereRaw);
            }

            $data = $data->skip($start)
                         ->join('products', 'product_has_interests.product_id', 'products.id')
                         ->join('people', 'products.person_id', 'people.id')
                         ->leftJoin('stores', 'people.id', 'stores.person_id')
                         ->leftJoin('people as sellers', 'products.person_id', 'sellers.id')
                         ->leftJoin('user_apps as user_apps_seller', 'sellers.id', 'user_apps_seller.person_id')
                         ->join('user_apps', 'product_has_interests.user_app_id', 'user_apps.id')
                         ->join('people as user', 'user_apps.person_id', 'user.id')
                         ->limit($length)
                         ->select([
                            'products.id as products_id',
                            'products.name as products_name',
                            'products.type as products_type',
                            'stores.id as stores_id',
                            'user_apps_seller.id as sellers_id',
                            'people.name as stores_name',
                            'user_apps.id as user_id',
                            'user.name as user_name',
                            'product_has_interests.id as product_has_interest_id',
                            'product_has_interests.status as product_has_interests_status',
                            'product_has_interests.created_at as product_has_interests_date'
                         ]);

            $dataWhere = clone($data);

            $data = $data->get();
            $array['data'] = [];      
            foreach($data as $row){
                if ($row->product_has_interests_status == '0') {
                    $status = '<span class="td-status">Negociando</span>';
                    $actions = '<div class="d-i-flex">
                                    <a title="Vendido" data-toggle="tooltip" data-placement="top" href="#" class="btn-warning btn btn-xs m-l-xs update-interest-status" product-has-interest-id="' . $row->product_has_interest_id . '" status="1"> <i class="fa fa-dollar fa-fw"></i></a>
                                    <a title="Cancelado" data-toggle="tooltip" data-placement="top" href="#" class="btn-danger btn btn-xs m-l-xs update-interest-status" product-has-interest-id="' . $row->product_has_interest_id . '" status="2"> <i class="fa fa-ban fa-fw"></i></a>
                                </div>';
                } elseif ($row->product_has_interests_status == '1') {
                    $status = '<span class="td-status">Vendido</span>';
                    $actions = '<div class="d-i-flex">
                                    <a title="Cancelado" data-toggle="tooltip" data-placement="top" href="#" class="btn-danger btn btn-xs m-l-xs update-interest-status" product-has-interest-id="' . $row->product_has_interest_id . '" status="2"> <i class="fa fa-ban fa-fw"></i></a>
                                    <a title="Negociando" data-toggle="tooltip" data-placement="top" href="#" class="btn-primary btn btn-xs m-l-xs update-interest-status" product-has-interest-id="' . $row->product_has_interest_id . '" status="0"> <i class="fa fa-briefcase fa-fw"></i></a>
                                </div>';
                } else {
                    $status = '<span class="td-status">Cancelado</span>';
                    $actions = '<div class="d-i-flex">
                                    <a title="Vendido" data-toggle="tooltip" data-placement="top" href="#" class="btn-warning btn btn-xs m-l-xs update-interest-status" product-has-interest-id="' . $row->product_has_interest_id . '" status="1"> <i class="fa fa-dollar fa-fw"></i></a>
                                    <a title="Negociando" data-toggle="tooltip" data-placement="top" href="#" class="btn-primary btn btn-xs m-l-xs update-interest-status" product-has-interest-id="' . $row->product_has_interest_id . '" status="0"> <i class="fa fa-briefcase fa-fw"></i></a>
                                </div>';
                }

                $array['data'][] = array(
                    $row->product_has_interest_id,
                    '<a href="' . url('painel/products/' . $row->products_id) . '" target="_blank">' . $row->products_name . '</a>',
                    ($row->products_type == 'L') ? '<a href="' . url('painel/store/' . $row->stores_id . '/edit') . '" target="_blank">' . $row->stores_name . '</a>' : '<a href="' . url('painel/users-app/' . $row->sellers_id) . '" target="_blank">' . $row->stores_name . '</a>',
                    '<a href="' . url('painel/users-app/' . $row->user_id) . '" target="_blank">' . $row->user_name . '</a>',
                    date('d/m/Y', strtotime($row->product_has_interests_date)),
                    $status,
                    $actions
                );
            }

            $array['draw'] = $_GET['draw'];
            $array['recordsFiltered'] = ($whereRaw == "") ? ProductHasInterest::count() : $dataWhere->whereRaw($whereRaw)->count();
            $array['recordsTotal'] = ProductHasInterest::count();

            return response()->json($array);

        }

        $collumns = ['Código', 'Produto', 'Vendedor', 'Usuário', 'Data do interesse', 'Status', 'Ações'];

        return view(\Route::getCurrentRoute()->getPrefix() . '.simple.list')
                    ->with([
                        'collumns' => $collumns,
                        'breadcrumb' => $this->breadcrumb
                    ]);
    }

    public function create()
    {
        // 
    }

    public function store(Request $request)
    {
        // 
    }

    public function edit($id)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // 
    }

    public function show($id)
    {
        // 
    }

    public function destroy($id)
    {
        // 
    }
     
}
