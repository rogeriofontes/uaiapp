<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helper;
use Validator;
use View;
use Session;
use Storage;
use Form;
use App\User;
use App\Person;
use App\Role;

class UserController extends Controller
{
    public function __construct()
    {        
        parent::__construct();

        $this->pagina        = "Usuários";
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
            $collumns = ['id', 'name', 'email', 'role', 'created_at'];

            $orderColumn = $_GET['order'][0]['column'];
            $oderDir     = $_GET['order'][0]['dir'];
            $start       = $_GET['start'];
            $length      = $_GET['length'];
            $search      = $_GET['search']['value'];

            $data = User::orderByRaw($collumns[$orderColumn] . ' ' . $oderDir);
            
            $whereRaw = "";
            if($search != ""){
                $whereRaw = 'users.email LIKE "%' .$search. '%" OR
                             people.name LIKE  "%' .$search. '%" OR
                             roles.role  LIKE  "%' .$search. '%"
                            ';     

                $data->whereRaw($whereRaw);
            }

            $data = $data->skip($start)
                         ->limit($length)
                         ->join('people', 'users.id', 'people.user_id')
                         ->join('roles', 'people.role_id', 'roles.id')
                         ->select(['users.id', 'users.email', 'users.created_at', 'people.name', 'roles.role'])
                         ->get();
                         $array['data'] = [];
            foreach($data as $row){
                $array['data'][] = array(
                    $row->id,
                    $row->name,
                    $row->email,
                    $row->role,
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
            $array['recordsFiltered'] = ($whereRaw == "") ? User::count() : User::whereRaw($whereRaw)->count();
            $array['recordsTotal'] = User::count();

            return response()->json($array);

        }

        $collumns = ['Código', 'Nome', 'Email', 'Role', 'Data de Cadastro', 'Ações'];

        return view(\Route::getCurrentRoute()->getPrefix() . '.simple.list')
                    ->with([
                        'collumns'      => $collumns,
                        'breadcrumb'    => $this->breadcrumb
                    ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
            if($fillable != 'user_id' && $fillable != 'role_id' && $fillable != 'type_person' && $fillable != 'cpf_cnpj'){
                $fillables[] = $fillable;
                $labels[$fillable]  = $model->getLabels()[$fillable];
            }
        }

        $model = new User();
        foreach($model->getFillable() as $fillable){
            if($fillable != 'api_token'){
                $fillables[] = $fillable;
                $labels[$fillable]  = $model->getLabels()[$fillable];
            }
        }

        $fillablesSelects[] = ['name' => 'role_id', 'values' => Role::pluck('role', 'id')];  

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dados = $request->all();

        $rules    = [
            'email'     => 'required|email',
            'password'  => 'required|min:6',
            'name'      => 'required',
            'role_id'   => 'required'
        ];
        $nomes    = [
            'name'      => 'Nome',
            'email'     => 'E-mail',
            'password'  => 'Senha',
            'role_id'   => 'Role'
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

        $dados['password'] = bcrypt($dados['password']);
        $data = new User($dados);        
        $result = $data->save();

        if($result)
        {
            $data->getPerson()->create($dados);
            Session::flash('success', true);
        }
        else
        {
            Session::flash('error', true);
        }

        if($dados['submit'] == 'close'){
            return redirect()->route($this->route . '.index');
        }else{
            return redirect()
                ->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::with('getPerson')->find($id);
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
            if($fillable != 'user_id' && $fillable != 'type_person' && $fillable != 'cpf_cnpj'){
                if($fillable == 'role_id'){
                    $otherElements .= '<div class="form-group">';
                    $otherElements .= Form::label($fillable, ucwords($model->getLabels()[$fillable]), ['class' => 'col-sm-2 control-label']);
                    $otherElements .= ' <div class="col-sm-8">';
                    $otherElements .= Form::select($fillable, Role::pluck('role', 'id'), $data->getPerson[$fillable], ['class' => 'form-control', 'placeholder' => 'Selecione']);
                    $otherElements .= '</div>';
                    $otherElements .= '</div>';
                }else if($fillable == 'media_id'){
                    $otherElements .= '<div class="form-group">';
                    $otherElements .= Form::label($fillable, ucwords($model->getLabels()[$fillable]), ['class' => 'col-sm-2 control-label']);
                    $otherElements .= ' <div class="col-sm-8">';
                    $otherElements .= Form::file('file', ['class' => 'form-control']);
                    $otherElements .= Form::hidden($fillable, $data->getPerson[$fillable]);
                    $otherElements .= '</div>';
                    $otherElements .= '</div>';

                    if($data->getPerson->getMedia != null){
                        $otherElements .= '<div class="form-group">';
                        $otherElements .= '<div class="col-sm-2">';
                        $otherElements .= '</div>';
                        $otherElements .= '<div class="col-sm-8">';
                        $otherElements .= '<img src="'.Storage::disk('public')->url($data->getPerson->getMedia->path).'" class="img-responsive" />';
                        $otherElements .= '</div>';
                        $otherElements .= '</div>';
                    }                   
                }else if($fillable == 'birthday'){
                    $otherElements .= '<div class="form-group">';
                    $otherElements .= Form::label($fillable,ucwords($model->getLabels()[$fillable]), ['class' => 'col-sm-2 control-label']);
                    $otherElements .= ' <div class="col-sm-8">';
                    $otherElements .= Form::date($fillable, $data->getPerson[$fillable], ['class' => 'form-control']);
                    $otherElements .= '</div>';
                    $otherElements .= '</div>';
                }else{
                    $otherElements .= '<div class="form-group">';
                    $otherElements .= Form::label($fillable, ucwords($model->getLabels()[$fillable]), ['class' => 'col-sm-2 control-label']);
                    $otherElements .= ' <div class="col-sm-8">';
                    $otherElements .= Form::text($fillable, $data->getPerson[$fillable], ['class' => 'form-control']);
                    $otherElements .= '</div>';
                    $otherElements .= '</div>';
                }
            }
        }
        foreach($data->getFillable() as $fillable){
            if($fillable != 'api_token'){
                $fillables[] = $fillable;
                $labels[$fillable] = $data->getLabels()[$fillable];
            }
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dados = $request->all();
        
        $rules    = [
            'email'     => 'required|email',
            'name'      => 'required',
            'role_id'   => 'required'
        ];
        $nomes    = [
            'name'      => 'Nome',
            'email'     => 'E-mail',
            'password'  => 'Senha',
            'role_id'   => 'Role'
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

        $file = $request->file('file');
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

        $data = User::find($id);
        $dados['media_id'] = ($dados['media_id'] == null) ? NULL : $dados['media_id'];
        $dados['password'] = ($dados['password'] != '') ? bcrypt($dados['password']) : $data->password;
        $result = $data->fill($dados)->save();

        $data->getPerson->fill($dados)->save();

        if($result)
        {
            Session::flash('success', true);
        }
        else
        {
            Session::flash('error', true);
        }

        if($dados['submit'] == 'close'){
            return redirect()->route($this->route . '.index');
        }else{
            return redirect()
                ->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::find($id);
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
