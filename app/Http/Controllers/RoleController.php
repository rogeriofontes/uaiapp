<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helper;
use Validator;
use View;
use Session;
use Form;
use App\Role;
use App\Menu;
use App\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->pagina        = "Roles";
        $this->breadcrumb[] = ['route' => \Route::getCurrentRoute()->getPrefix(), 'pagina' => 'Configurações'];
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
            $collumns = ['id', 'role', 'created_at'];

            $orderColumn = $_GET['order'][0]['column'];
            $oderDir     = $_GET['order'][0]['dir'];
            $start       = $_GET['start'];
            $length      = $_GET['length'];
            $search      = $_GET['search']['value'];

            $data = Role::orderByRaw($collumns[$orderColumn] . ' ' . $oderDir);
            
            $whereRaw = "";
            if($search != ""){
                $whereRaw = 'role  LIKE "%' .$search. '%"';       

                $data->whereRaw($whereRaw);
            }

            $data = $data->skip($start)
                         ->limit($length)
                         ->get();

                         $array['data'] = [];         
            foreach($data as $row){
                $array['data'][] = array(
                    $row->id,
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
            $array['recordsFiltered'] = ($whereRaw == "") ? Role::count() : Role::whereRaw($whereRaw)->count();
            $array['recordsTotal'] = Role::count();

            return response()->json($array);

        }        

        $collumns = ['Código', 'Role', 'Data de Cadastro', 'Ação'];

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

        $model = new Role();        
        foreach($model->getFillable() as $fillable){
            $fillables[] = $fillable;
            $labels[$fillable]  = $model->getLabels()[$fillable];
        }        

        $otherElements = '<div class="form-group">
                            <div class="col-sm-2">                                    
                            </div>
                            <div class="col-sm-8">
                                <a href="#" class="marcarTudo col-sm-3 control-label">Marcar Tudo</a>
                                <a href="#" class="desmarcarTudo col-sm-3 control-label">Desmarcar Tudo</a>
                            </div>
                        </div>
                        <div class="divChecks">
                        ';

        foreach(Menu::whereRaw('ISNULL(menu_id)')->get() as $menu){
            $otherElements .= '<div class="form-group">
                                <div class="col-sm-2">                                    
                                </div>
                                <div class="col-sm-8">
                                <input type="checkbox"  name="menu[]" id="'. $menu->id . '" value="'. $menu->id. '" />
                                &nbsp; 
                                <i class="fa '. $menu->icon .'" aria-hidden="true"></i>
                                <label class="ipCheckProfileFather" for="'. $menu->id. '">'. $menu->menu .'</label> <br/>';
                                foreach($menu->getChildren as $children){
                                $otherElements .= '<input class="' . $menu->id .'" style="margin-left:20px;" type="checkbox" name="menu[]" id="' . $children->id.'" value="' . $children->id .'" />
                                    &nbsp; <i class="fa ' .  $children->icon .'" aria-hidden="true"></i>
                                    <label for="' . $children->id. '">' . $children->menu .'</label> <br/>';

                                    foreach($children->getChildren as $son){
                                        $otherElements .= '<input class="' . $menu->id .'" style="margin-left:40px;" type="checkbox" name="menu[]" id="' . $son->id.'" value="' . $son->id .'" />
                                        &nbsp; <i class="fa ' .  $son->icon .'" aria-hidden="true"></i>
                                        <label for="' . $son->id. '">' . $son->menu .'</label> <br/>';

                                        foreach($son->getChildren as $c){
                                            $otherElements .= '<input class="' . $menu->id .'" style="margin-left:40px;" type="checkbox" name="menu[]" id="' . $c->id.'" value="' . $c->id .'" />
                                            &nbsp; <i class="fa ' .  $c->icon .'" aria-hidden="true"></i>
                                            <label for="' . $c->id. '">' . $c->menu .'</label> <br/>';
                                        }
                                    }
                                }
                                $otherElements .= '<hr />
                                </div>
                              </div>
            ';
        }

        $otherElements .= '</div>';


        $scripts = "//Marcar todos os checkbox do perfil
        $('.marcarTudo').on('click', function(){
          $('.divChecks').find('input').each(function(i,j){
              $(this).prop('checked', true);
          });
          return false;
        });
        
        //Desmarcar todos os checkbox do perfil
        $('.desmarcarTudo').on('click', function(){
          $('.divChecks').find('input').each(function(i,j){
              $(this).prop('checked', false);
          });
          return false;
        });
        
        //Marcar-Desmarcar os checkbox dos filhos
        $('.ipCheckProfileFather').on('click', function(){
            if ($('#'+$(this).attr('for')).is(':checked')) {
              $('#'+$(this).attr('for')).prop('checked', false);
            }else{
              $('#'+$(this).attr('for')).prop('checked', true);
            }
        
            $('.divChecks').find('.'+$(this).attr('for')).each(function(i,j){
              if ($(this).is(':checked')) {
                $(this).prop('checked', false);
              }else{
                $(this).prop('checked', true);
              }      
            });
          return false;
        });";

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
            'role'     => 'required',
        ];
        $nomes    = [
            'role'     => 'Role'
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

        $data = new Role($dados);
        $result = $data->save();

        if($result)
        {
            foreach($dados['menu'] as $valores){
                $permission = new Permission(array(
                                            "role_id"    => $data->id,
                                            "menu_id"     => $valores
                                        ));
                $permission->save();
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
        $data = Role::find($id);
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

        $model = new Role();
        foreach($model->getFillable() as $fillable){
            $fillables[] = $fillable;
            $labels[$fillable]  = $model->getLabels()[$fillable];
        }

        $otherElements = '<div class="form-group">
                            <div class="col-sm-2">                                    
                            </div>
                            <div class="col-sm-8">
                                <a href="#" class="marcarTudo col-sm-3 control-label">Marcar Tudo</a>
                                <a href="#" class="desmarcarTudo col-sm-3 control-label">Desmarcar Tudo</a>
                            </div>
                        </div>
                        <div class="divChecks">
                        ';

        foreach(Menu::whereRaw('ISNULL(menu_id)')->get() as $menu){
            $checked = ($data->getPermission->where('menu_id', $menu->id)->first() != null) ? "checked" : "";
            $otherElements .= '<div class="form-group">
                                <div class="col-sm-2">                                    
                                </div>
                                <div class="col-sm-8">
                                <input type="checkbox" '. $checked .'  name="menu[]" id="'. $menu->id . '" value="'. $menu->id. '" />
                                &nbsp; 
                                <i class="fa '. $menu->icon .'" aria-hidden="true"></i>
                                <label class="ipCheckProfileFather" for="'. $menu->id. '">'. $menu->menu .'</label> <br/>';
                                foreach($menu->getChildren as $children){
                                    $checked = ($data->getPermission->where('menu_id',$children->id)->first() != null) ? "checked" : "";
                                    $otherElements .= '<input '. $checked .' class="' . $menu->id .'" style="margin-left:20px;" type="checkbox" name="menu[]" id="' . $children->id.'" value="' . $children->id .'" />
                                        &nbsp; <i class="fa ' .  $children->icon .'" aria-hidden="true"></i>
                                        <label for="' . $children->id. '">' . $children->menu .'</label> <br/>';

                                        foreach($children->getChildren as $son){
                                            $checked = ($data->getPermission->where('menu_id',$son->id)->first() != null) ? "checked" : "";
                                            $otherElements .= '<input '. $checked .' class="' . $menu->id .'" style="margin-left:40px;" type="checkbox" name="menu[]" id="' . $son->id.'" value="' . $son->id .'" />
                                            &nbsp; <i class="fa ' .  $son->icon .'" aria-hidden="true"></i>
                                            <label for="' . $son->id. '">' . $son->menu .'</label> <br/>';

                                            foreach($son->getChildren as $c){
                                                $checked = ($data->getPermission->where('menu_id',$c->id)->first() != null) ? "checked" : "";
                                                $otherElements .= '<input  '. $checked .' class="' . $menu->id .'" style="margin-left:40px;" type="checkbox" name="menu[]" id="' . $c->id.'" value="' . $c->id .'" />
                                                &nbsp; <i class="fa ' .  $c->icon .'" aria-hidden="true"></i>
                                                <label for="' . $c->id. '">' . $c->menu .'</label> <br/>';
                                            }
                                        }
                                }
                                $otherElements .= '<hr />
                                </div>
                                </div>
            ';
        }                    
        
        $otherElements .= '</div>';                

        $scripts = "//Marcar todos os checkbox do perfil
        $('.marcarTudo').on('click', function(){
          $('.divChecks').find('input').each(function(i,j){
              $(this).prop('checked', true);
          });
          return false;
        });
        
        //Desmarcar todos os checkbox do perfil
        $('.desmarcarTudo').on('click', function(){
          $('.divChecks').find('input').each(function(i,j){
              $(this).prop('checked', false);
          });
          return false;
        });
        
        //Marcar-Desmarcar os checkbox dos filhos
        $('.ipCheckProfileFather').on('click', function(){
            if ($('#'+$(this).attr('for')).is(':checked')) {
              $('#'+$(this).attr('for')).prop('checked', false);
            }else{
              $('#'+$(this).attr('for')).prop('checked', true);
            }
        
            $('.divChecks').find('.'+$(this).attr('for')).each(function(i,j){
              if ($(this).is(':checked')) {
                $(this).prop('checked', false);
              }else{
                $(this).prop('checked', true);
              }      
            });
          return false;
        });";

        return view(\Route::getCurrentRoute()->getPrefix() . '.simple.edit')
                    ->with([
                        'breadcrumb'        => $this->breadcrumb,
                        'data'             => $data,
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
            'role'  => 'required'
        ];
        $nomes    = [
            'role'  => 'Role'
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

        $data = Role::find($id);
        $result = $data->fill($dados)->save();

        if($result)
        {
            $data->getPermission()->delete();
            foreach($dados['menu'] as $valores){
                $permission = new Permission(array(
                                            "role_id"    => $data->id,
                                            "menu_id"     => $valores
                                        ));
                $permission->save();
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Role::find($id);
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
