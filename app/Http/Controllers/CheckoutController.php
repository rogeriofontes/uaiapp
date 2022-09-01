<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helper;
use Validator;
use View;
use Session;
use Form;
use Storage;
use DB;
use App\Checkout;

class CheckoutController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->pagina        = "Checkout";
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
            $collumns = ['id', 'code_pagseguro', 'date_pagseguro', 'status', 'paymentMethod', 'plan', 'product', 'user', 'created_at'];

            $orderColumn = $_GET['order'][0]['column'];
            $oderDir     = $_GET['order'][0]['dir'];
            $start       = $_GET['start'];
            $length      = $_GET['length'];
            $search      = $_GET['search']['value'];

            $data = Checkout::orderByRaw($collumns[$orderColumn] . ' ' . $oderDir)
                            ->join('user_apps', 'checkouts.user_app_id', 'user_apps.id')
                            ->join('people', 'user_apps.person_id', 'people.id')
                            ->join('plans', 'checkouts.plan_id', 'plans.id')
                            ->join('products', 'checkouts.product_id', 'products.id')
                            ->select([
                                'checkouts.*',
                                'people.name as user',
                                'plans.plan as plan',
                                'products.name as product'
                            ]);

            $whereRaw = "";
            if($search != ""){
                $search   = \str_replace(" ", "%", $search);
                $whereRaw = '(status LIKE "%' .$search. '%" OR 
                              people.name LIKE "%'.$search.'%" OR
                              paymentMethod LIKE "%' .$search. '%" OR
                              code_pagseguro LIKE "%' .$search. '%" OR
                              plans.plan LIKE "%' .$search. '%" OR
                              products.name LIKE "%' .$search. '%"
                              )';       
                $data->whereRaw($whereRaw);
            }

            $dataWhere = clone($data);

            $data = $data->skip($start)
                         ->limit($length)
                         ->get();

            $array['data'] = array();             

            foreach($data as $row){
                $array['data'][] = array(
                    $row->id,
                    ($row->code_pagseguro) ?? "-",
                    $row->date_pagseguro,
                    $row->status . ' - '.$row->getStatusLegend(),
                    $row->getPaymentMethod(),
                    $row->plan,
                    $row->product,
                    $row->user,
                    $row->created_at->format('d/m/Y H:i:s')                    
                );
            }

            $array['draw'] = $_GET['draw'];
            $array['recordsFiltered'] = $dataWhere->count();
            $array['recordsTotal'] = Checkout::count();

            return response()->json($array);

        }

        $collumns = ['Código', 'Cod. Pagseguro', 'Data', 'Status', 'M. de Pagamento', 'Plano', 'Produto', 'Usuário', 'Data de Cadastro'];

        return view(\Route::getCurrentRoute()->getPrefix() . '.simple.list')
                    ->with([
                        'collumns' => $collumns,
                        'breadcrumb' => $this->breadcrumb
                    ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect()->back();
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
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect()->back();
    }
}
