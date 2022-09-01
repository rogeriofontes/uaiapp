<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helper;
use Validator;
use View;
use Session;
use Storage;
use Form;
use DB;
use App\Store;
use App\Person;
use App\User;
use App\Address;
use App\City;

class StoreController extends Controller
{
    public function __construct()
    {        
        parent::__construct();

        $this->pagina        = "Lojas";
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
            $collumns = ['stores.id', 'person_id', 'created_at'];

            $orderColumn = $_GET['order'][0]['column'];
            $oderDir     = $_GET['order'][0]['dir'];
            $start       = $_GET['start'];
            $length      = $_GET['length'];
            $search      = $_GET['search']['value'];
            
            $data = Store::orderByRaw($collumns[$orderColumn] . ' ' . $oderDir);
            
            $whereRaw = "";
            if($search != ""){
                $whereRaw = 'people.name LIKE "%' .$search. '%" OR users.email LIKE "%' .$search. '%"';
                $data->whereRaw($whereRaw);
            }

            $data = $data->skip($start)
                         ->limit($length)
                         ->join('people', 'stores.person_id', 'people.id')
                         ->join('users', 'people.user_id', 'users.id')
                         ->select(['people.name', 'users.email', 'stores.created_at', 'stores.id']);
            
            $qtd = clone($data);

            $data = $data->get();
            $array['data'] = [];
            foreach($data as $row){
                $array['data'][] = array(
                    $row->id,
                    $row->name,
                    $row->email,
                    $row->created_at->format('d/m/Y H:i:s'),
                    '<a title="Editar" data-toggle="tooltip" data-placement="top" href="' . route($this->route . '.edit', $row->id) . '" class="btn-success btn btn-xs"> <i class="fa fa-pencil"></i> Editar</a>
                    <a title="Excluir" data-toggle="tooltip" data-placement="top" class="label-danger btn btn-xs btn-del">
                        <i class="fa fa-trash"></i> Excluir'
                    .Form::open(['method'=>'DELETE', 'route'=>[ $this->route .'.destroy', $row->id], 'class'=>'form-delete', 'style' => 'display: none']) 
                    .Form::close()
                    .'</a>'
                );
            }

            $array['draw'] = $_GET['draw'];
            $array['recordsFiltered'] = ($whereRaw == "") ? Store::count() : $qtd->count();
            $array['recordsTotal'] = Store::count();

            return response()->json($array);

        }

        $collumns = ['Código', 'Nome', 'Email', 'Data de Cadastro', 'Ações'];

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

        $model = new Person();
        foreach($model->getFillable() as $fillable){
            if($fillable != 'user_id' && $fillable != 'role_id'){
                $fillables[] = $fillable;
                $labels[$fillable]  = $model->getLabels()[$fillable];
            }
        }

        $model = new User();
        foreach($model->getFillable() as $fillable){
            if($fillable != 'api_token' && $fillable != 'password'){
                $fillables[] = $fillable;
                $labels[$fillable]  = $model->getLabels()[$fillable];
            }
        }

        $model = new Store();
        foreach($model->getFillable() as $fillable){
            if($fillable != 'person_id'){
                $fillables[] = $fillable;
                $labels[$fillable]  = $model->getLabels()[$fillable];
            }
        }

        return view(\Route::getCurrentRoute()->getPrefix() . '.store.create')
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

        $rules = [
            'name'          => 'required',
            'type_person'   => 'required',
            'cpf_cnpj'      => 'nullable',
            'email'         => 'required|email',
            'phone'         => 'required',
            'media_id'      => 'required|mimes:jpg,jpeg,png'
        ];
        $nomes = [
            'name'          => 'Nome',
            'type_person'   => 'Tipo de Pessoa',
            'cpf_cnpj'      => 'CPF/CNPJ',
            'email'         => 'E-mail',
            'phone'         => 'Telefone',
            'media_id'      => 'Imagem'
        ];
        $messages = [];

        $validator = Validator::make($dados, $rules, $messages);
        $validator->setAttributeNames($nomes);
  
        if ($validator->fails()) 
        {
            Session::flash('error', true);
            return redirect()
                      ->back()
                      ->withErrors($validator)
                      ->withInput();
        }

        $file = $request->file('media_id');
        if($file != null)
        {
            $resultMedia = (new MediaController)->putMedia($file, 20000000, 1);
            if(!$resultMedia['save'])
            {
                Session::flash('error', true);
                return redirect()->back()->withErrors($resultMedia['message_error'])->withInput($dados);
            }

            $dados['media_id'] = $resultMedia['media_id'];
        }

        $data = new User($dados);
        $result = $data->save();

        if($result)
        {
            // Create Person
            $data->getPerson()->create($dados);
            // Create Store
            $data->getPerson->getStore()->create($dados);
            // Create Address
            $data->getPerson->getAddress()->create($dados);
            
            Session::flash('success', true);
        }
        else
        {
            Session::flash('error', true);
        }

        return redirect()->back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = Store::find($id);
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

        $model = new Person();
        foreach($model->getFillable() as $fillable){
            if($fillable != 'user_id' && $fillable != 'role_id'){
                $fillables[] = $fillable;
                $labels[$fillable]  = $model->getLabels()[$fillable];
            }
        }

        $model = new User();
        foreach($model->getFillable() as $fillable){
            if($fillable != 'api_token' && $fillable != 'password'){
                $fillables[] = $fillable;
                $labels[$fillable]  = $model->getLabels()[$fillable];
            }
        }

        $model = new Store();
        foreach($model->getFillable() as $fillable){
            if($fillable != 'person_id'){
                $fillables[] = $fillable;
                $labels[$fillable]  = $model->getLabels()[$fillable];
            }
        }

        return view(\Route::getCurrentRoute()->getPrefix() . '.store.edit')
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
        
        $rules = [
            'name'          => 'required',
            'type_person'   => 'required',
            'cpf_cnpj'      => 'nullable',
            'email'         => 'required|email',
            'phone'         => 'required'
        ];
        $nomes = [
            'name'          => 'Nome',
            'type_person'   => 'Tipo de Pessoa',
            'cpf_cnpj'      => 'CPF/CNPJ',
            'email'         => 'E-mail',
            'phone'         => 'Telefone'
        ];
        $messages = [];

        $validator = Validator::make($dados, $rules, $messages);
        $validator->setAttributeNames($nomes);
    
        if ($validator->fails()) 
        {
            Session::flash('error', true);
            return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $file = $request->file('media_id');
        if($file != null)
        {
            $resultMedia = (new MediaController)->putMedia($file, 20000000, 1);
            if($resultMedia['save']){
                (new MediaController)->delMedia($dados['media_id']);
                $dados['media_id'] = $resultMedia['media_id'];
            }else{
                Session::flash('error', true);
                return redirect()->back()->withErrors($resultMedia['message_error'])->withInput($dados);
            }
        }

        $data = Store::find($id);
        $result = $data->fill($dados)->save();
        $data->getPerson->fill($dados)->save();
        $data->getPerson->getUser->fill($dados)->save();
        $data->getPerson->getAddress->fill($dados)->save();

        if($result)
        {
            Session::flash('success', true);
        }
        else
        {
            Session::flash('error', true);
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        $data = Store::find($id);
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
