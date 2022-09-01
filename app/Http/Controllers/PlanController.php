<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Storage;
use Session;
use Helper;
use View;
use Form;
use App\Plan;

class PlanController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->pagina       = "Planos";
        $this->breadcrumb[] = ['route' => \Route::getCurrentRoute()->getPrefix() . '/' . $this->route, 'pagina' => $this->pagina];

        View::share([
            'title'         => $this->pagina,
            'routeFather'   => $this->route,
        ]);
    }

    public function index()
    {
        if(isset($_GET['draw'])){

            $array = array();
            $collumns = ['id', 'plan', 'days', 'price', 'created_at'];

            $orderColumn = $_GET['order'][0]['column'];
            $oderDir     = $_GET['order'][0]['dir'];
            $start       = $_GET['start'];
            $length      = $_GET['length'];
            $search      = $_GET['search']['value'];

            $data = Plan::orderByRaw($collumns[$orderColumn] . ' ' . $oderDir);
            
            $whereRaw = "";
            if($search != "") {
                $whereRaw = 'plan LIKE "%' .$search. '%"';
                $data->whereRaw($whereRaw);
            }

            $data = $data->skip($start)
                         ->limit($length)
                         ->get();

            $array['data'] = [];

            foreach($data as $row) {
                $array['data'][] = array(
                    $row->id,
                    $row->plan,
                    $row->days,
                    $row->getPrice(),
                    $row->created_at->format('d/m/Y H:i:s'),
                    '<a title="Editar" data-toggle="tooltip" data-placement="top" href="' . route($this->route . '.edit', $row->id) . '" class="btn-primary btn btn-xs"> <i class="fa fa-pencil"></i> Editar</a>
                    <a title="Excluir" data-toggle="tooltip" data-placement="top" class="label-danger btn btn-xs btn-del">
                        <i class="fa fa-trash"></i> Excluir'
                    .Form::open(['method'=>'DELETE', 'route'=>[ $this->route .'.destroy', $row->id], 'class'=>'form-delete', 'style' => 'display: none']) 
                    .Form::close()
                    .'</a>'
                );
            }

            $array['draw'] = $_GET['draw'];
            $array['recordsFiltered'] = ($whereRaw == "") ? Plan::count() : Plan::whereRaw($whereRaw)->count();
            $array['recordsTotal'] = Plan::count();

            return response()->json($array);

        }        

        $collumns = ['Código', 'Plano', 'Dias', 'Preço', 'Data de Cadastro', 'Ação'];

        return view(\Route::getCurrentRoute()->getPrefix() . '.simple.list')
                    ->with([
                        'collumns'      => $collumns,
                        'breadcrumb'    => $this->breadcrumb
                    ]);
    }

    public function create()
    {
        $this->breadcrumb[] = ['route' => $this->route, 'pagina' => 'Adicionar'];
        $fillables          = array();
        $fillablesSelects   = array();
        $labels             = array();
        $otherElements      = '';        
        $scripts            = '';
        $css                = '';

        $model = new Plan();
        foreach($model->getFillable() as $fillable) {
            $fillables[]        = $fillable;
            $labels[$fillable]  = $model->getLabels()[$fillable];
        }

        return view(\Route::getCurrentRoute()->getPrefix() . '.simple.create')
                    ->with([
                        'breadcrumb'        => $this->breadcrumb,
                        'fillables'         => $fillables,
                        'fillablesSelects'  => $fillablesSelects,
                        'otherElements'     => $otherElements,                        
                        'css'               => $css,
                        'scripts'           => $scripts,
                        'gallery'           => false,
                        'labels'            => $labels
                    ]);
    }

    public function store(Request $request)
    {
        $dados = $request->all();
        $dados['price'] = str_replace('.', '', $dados['price']);
        $dados['price'] = str_replace(',', '.', $dados['price']);

        $rules = [
            'plan'  => 'required',
            'days'  => 'required',
            'price' => 'required|max:11'
        ];
        $nomes = [
            'plan'  => 'Plano',
            'days'  => 'Dias',
            'price' => 'Preço'
        ];
        $messages = [];

        $validator = Validator::make($dados, $rules, $messages);
        $validator->setAttributeNames($nomes);
  
        if ($validator->fails()) 
        {
            Session::flash('error', true);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = new Plan($dados);
        $result = $data->save();

        if($result)
        {
            Session::flash('success', true);
        }
        else
        {
            Session::flash('error', true);
        }

        if($dados['submit'] == 'close') {
            return redirect()->route($this->route . '.index');
        } else {
            return redirect()->back();
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = Plan::find($id);
        if($data == null)
        {
            abort(404);
        }

        $this->breadcrumb[] = ['route' => $this->route, 'pagina' => 'Editar'];
        $fillables          = array();
        $fillablesSelects   = array(); 
        $labels             = array();       
        $otherElements      = '';        
        $scripts            = '';
        $css                = '';

        foreach($data->getFillable() as $fillable){
            $fillables[]        = $fillable;
            $labels[$fillable]  = $data->getLabels()[$fillable];
        }   

        return view(\Route::getCurrentRoute()->getPrefix() . '.simple.edit')
                    ->with([
                        'breadcrumb'        => $this->breadcrumb,
                        'data'              => $data,
                        'fillables'         => $fillables,
                        'fillablesSelects'  => $fillablesSelects,
                        'otherElements'     => $otherElements,                        
                        'css'               => $css,
                        'scripts'           => $scripts,
                        'gallery'           => false,
                        'labels'            => $labels
                    ]);
    }

    public function update(Request $request, $id)
    {
        $dados = $request->all();
        $dados['price'] = str_replace('.', '', $dados['price']);
        $dados['price'] = str_replace(',', '.', $dados['price']);
        
        $rules = [
            'plan'  => 'required',
            'days'  => 'required',
            'price' => 'required|max:11'
        ];
        $nomes = [
            'plan'  => 'Plano',
            'days'  => 'Dias',
            'price' => 'Preço'
        ];
        $messages = [];

        $validator = Validator::make($dados, $rules, $messages);
        $validator->setAttributeNames($nomes);
    
        if ($validator->fails()) 
        {
            Session::flash('error', true);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = Plan::find($id);
        $result = $data->fill($dados)->save();

        if($result)
        {
            Session::flash('success', true);
        }
        else
        {
            Session::flash('error', true);
        }

        if($dados['submit'] == 'close') {
            return redirect()->route($this->route . '.index');
        } else {
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        $data = Plan::find($id);
        $result = $data->delete();

        if($result)
        {
            return response()->json(true);
        }
        else
        {
            return response()->json(false);
        }
    }    
}
