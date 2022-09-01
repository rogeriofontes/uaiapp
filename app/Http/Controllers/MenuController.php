<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helper;
use Validator;
use View;
use Session;
use Form;
use App\Menu;

class MenuController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->pagina        = "Menus";
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
            $collumns = ['id', 'menu', 'icon', 'route', 'created_at'];

            $orderColumn = $_GET['order'][0]['column'];
            $oderDir     = $_GET['order'][0]['dir'];
            $start       = $_GET['start'];
            $length      = $_GET['length'];
            $search      = $_GET['search']['value'];

            $data = Menu::orderByRaw($collumns[$orderColumn] . ' ' . $oderDir);
            
            $whereRaw = "";
            if($search != ""){
                $whereRaw = '(menu  LIKE "%' .$search. '%" OR route LIKE "%'.$search.'%")';       

                $data->whereRaw($whereRaw);
            }

            $data = $data->skip($start)
                         ->limit($length)
                         ->get();
                         $array['data'] = [];    
            foreach($data as $row){
                $array['data'][] = array(
                    $row->id,
                    $row->menu,
                    '<i class="fa ' . $row->icon . '"></i>',
                    $row->route,
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
            $array['recordsFiltered'] = ($whereRaw == "") ? Menu::count() : Menu::whereRaw($whereRaw)->count();
            $array['recordsTotal'] = Menu::count();

            return response()->json($array);

        }

        $collumns = ['Código', 'Menu', 'Ícone', 'Rota', 'Data de Cadastro', 'Ações'];

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
        $this->breadcrumb[] = ['route' => $this->route, 'pagina' => 'Adicionar'];
        $fillables          = array();
        $fillablesSelects   = array();    
        $labels             = array();    
        $otherElements      = '';        
        $scripts            = '';
        $css                = '';

        $model = new Menu();
        foreach($model->getFillable() as $fillable){
            if($fillable != 'menu_id' && $fillable != 'show'){
                $fillables[] = $fillable;
                $labels[$fillable]  = $model->getLabels()[$fillable];
            }
        }

        $fillablesSelects[$model->getLabels()['show']] = ['name' => 'show', 'values' => [1 => 'SIM', 0 => 'NÃO']];
        $fillablesSelects[$model->getLabels()['menu_id']] = ['name' => 'menu_id', 'values' => Menu::where('show', '1')->pluck('menu', 'id')];
        $fillablesSelects['Criar Rotas'] = ['name' => 'criar_rotas', 'values' => [1 => 'SIM', 0 => 'NÃO']];

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
            'menu'      => 'required',
            'icon'      => 'required',
            'route'     => 'required',
            'show'      => 'required'
        ];
        $nomes    = [
            'menu'      => 'Menu',
            'icon'      => 'ícone',
            'route'     => 'Rota',
            'show'      => 'Show'
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

        $dados['menu_id'] = ($dados['menu_id'] != '') ? $dados['menu_id'] : NULL;

        $inputRoute     = $dados['route'];
        $dados['route'] = $dados['route'] . '.index';

        $data = new Menu($dados);
        $result = $data->save();

        if($result)
        {

            if($dados['criar_rotas']){
                $menuFilhos = new Menu(array('menu'     => $dados['menu'] . ' - Show', 
                                            'route'     => $inputRoute . '.show', 
                                            'icon'      => 'fa-eye', 
                                            'show'      => '0',
                                            'menu_id'   => $data->id,
                                            ));
                $result = $menuFilhos->save();

                $menuFilhos = new Menu(array('menu'     => $dados['menu'] . ' - Create', 
                                            'route'     => $inputRoute . '.create', 
                                            'icon'      => 'fa-plus', 
                                            'show'      => '0',
                                            'menu_id'   => $data->id,
                                            ));
                $result = $menuFilhos->save();

                $menuFilhos = new Menu(array('menu'     => $dados['menu'] . ' - Edit', 
                                            'route'     => $inputRoute . '.edit', 
                                            'icon'      => 'fa-pencil', 
                                            'show'      => '0',
                                            'menu_id'   => $data->id
                                            ));
                $result = $menuFilhos->save();

                $menuFilhos = new Menu(array('menu'     => $dados['menu'] . ' - Destroy', 
                                            'route'     => $inputRoute . '.destroy', 
                                            'icon'      => 'fa-trash', 
                                            'show'      => '0',
                                            'menu_id'   => $data->id 
                                            ));
                $result = $menuFilhos->save();

                $menuFilhos = new Menu(array('menu'     => $dados['menu'] . ' - Store', 
                                            'route'     => $inputRoute . '.store', 
                                            'icon'      => 'fa-save', 
                                            'show'      => '0',
                                            'menu_id'   => $data->id
                                            ));
                $result = $menuFilhos->save();

                $menuFilhos = new Menu(array('menu'     => $dados['menu'] . ' - Update', 
                                            'route'     => $inputRoute . '.update', 
                                            'icon'      => 'fa-save',
                                            'show'      => '0',
                                            'menu_id' => $data->id
                                            ));
                $result = $menuFilhos->save();
            }

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
        $data = Menu::find($id);
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

        $model = new Menu();
        foreach($model->getFillable() as $fillable){
            if($fillable != 'menu_id' && $fillable != 'show'){
                $fillables[] = $fillable;
                $labels[$fillable]  = $model->getLabels()[$fillable];
            }
        }

        $fillablesSelects[$model->getLabels()['show']] = ['name' => 'show', 'values' => [1 => 'SIM', 0 => 'NÃO']];
        $fillablesSelects[$model->getLabels()['menu_id']] = ['name' => 'menu_id', 'values' => Menu::where('show', '1')->pluck('menu', 'id')];       

        return view(\Route::getCurrentRoute()->getPrefix() . '.simple.edit')
                    ->with([
                        'breadcrumb' => $this->breadcrumb,
                        'data'      => $data,
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
            'menu'      => 'required',
            'icon'      => 'required',
            'route'     => 'required',
            'show'      => 'required'
        ];
        $nomes    = [
            'menu'      => 'Menu',
            'icon'      => 'ícone',
            'route'     => 'Rota',
            'show'      => 'Show'
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

        $dados['menu_id'] = ($dados['menu_id'] != '') ? $dados['menu_id'] : NULL;

        $data = Menu::find($id);
        $result = $data->fill($dados)->save();

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
        $data = Menu::find($id);
        $result = $data->delete();

        if($result)
        {
            $data->getChildren()->delete();
            return response()->json(true);
        }
        else
        {
            return response()->json(false);
        }
    }    
}
