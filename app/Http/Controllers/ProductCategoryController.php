<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helper;
use Validator;
use View;
use Session;
use Form;
use Storage;
use App\ProductCategory;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->pagina        = "Categoria Produto";
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
            $collumns = ['id', 'category', 'created_at'];

            $orderColumn = $_GET['order'][0]['column'];
            $oderDir     = $_GET['order'][0]['dir'];
            $start       = $_GET['start'];
            $length      = $_GET['length'];
            $search      = $_GET['search']['value'];

            $data = ProductCategory::orderByRaw($collumns[$orderColumn] . ' ' . $oderDir);
            
            $whereRaw = "";
            if($search != ""){
                $whereRaw = '(category  LIKE "%' .$search. '%" OR created_at LIKE "%'.$search.'%")';       
                $data->whereRaw($whereRaw);
            }

            $data = $data->skip($start)
                         ->limit($length)
                         ->get();
                         $array['data'] = [];            
            foreach($data as $row){
                $array['data'][] = array(
                    $row->id,
                    '<img style="height:50px" src="'.Storage::disk('public')->url($row->getMedia->thumbnail_path).'" class="img-responsive" />',
                    $row->category,                    
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
            $array['recordsFiltered'] = ($whereRaw == "") ? ProductCategory::count() : ProductCategory::whereRaw($whereRaw)->count();
            $array['recordsTotal'] = ProductCategory::count();

            return response()->json($array);

        }

        $collumns = ['Código', 'Foto', 'Categoria', 'Data de Cadastro', 'Ações'];

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

        $model = new ProductCategory();
        foreach($model->getFillable() as $fillable){
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
            'category'      => 'required',
            'media_id'      => 'required'
        ];
        $nomes    = [
            'category'      => 'Categoria',
            'media_id'      => 'Ícone'
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

        $data = new ProductCategory($dados);
        $result = $data->save();

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
        $data = ProductCategory::find($id);
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
            if($fillable == 'media_id'){

                $otherElements .= '<div class="form-group">';
                $otherElements .= Form::label($fillable, ucwords($data->getLabels()[$fillable]), ['class' => 'col-sm-2 control-label']);
                $otherElements .= ' <div class="col-sm-8">';
                $otherElements .= Form::file('file', ['class' => 'form-control']);
                $otherElements .= Form::hidden($fillable, $data->media_id);
                $otherElements .= '</div>';
                $otherElements .= '</div>';

                if($data->getMedia != null){
                    $otherElements .= '<div class="form-group">';
                    $otherElements .= '<div class="col-sm-2">';
                    $otherElements .= '</div>';
                    $otherElements .= '<div class="col-sm-8">';
                    $otherElements .= '<img src="'.Storage::disk('public')->url($data->getMedia->path).'" class="img-responsive" />';
                    $otherElements .= '</div>';
                    $otherElements .= '</div>';
                }

            }else{
                $fillables[]        = $fillable;
                $labels[$fillable]  = $data->getLabels()[$fillable];
            }
        }   

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
            'category'      => 'required',
        ];
        $nomes    = [
            'category'      => 'Categoria',
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

        $data = ProductCategory::find($id);

        $file = $request->file('file');
        if($file != null)
        {
            $resultMedia = (new MediaController)->putMedia($file, 20000000, 1);
            if($resultMedia['save']){
                $mediaIdOld = $dados['media_id'];
                $dados['media_id'] = $resultMedia['media_id'];
            }else{
                Session::flash('error', true);
                return redirect()->back()->withErrors($resultMedia['message_error'])->withInput($dados);
            }
        }

        $result = $data->fill($dados)->save();

        if($result)
        {
            (new MediaController)->delMedia($mediaIdOld);
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
        $data = ProductCategory::find($id);
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
