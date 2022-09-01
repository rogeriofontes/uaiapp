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
use App\ProductSubCategory;

class ProductSubCategoryController extends Controller
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
            $collumns = ['id', 'subcategory', 'category', 'created_at'];

            $orderColumn = $_GET['order'][0]['column'];
            $oderDir     = $_GET['order'][0]['dir'];
            $start       = $_GET['start'];
            $length      = $_GET['length'];
            $search      = $_GET['search']['value'];

            $data = ProductSubCategory::orderByRaw($collumns[$orderColumn] . ' ' . $oderDir);
            
            $whereRaw = "";
            if($search != ""){
                $whereRaw = '(category  LIKE "%' .str_replace(" ", "%", $search). '%" OR subcategory LIKE "%'.str_replace(" ", "%", $search).'%" OR created_at LIKE "%'.str_replace(" ", "%", $search).'%")';       
                $data->whereRaw($whereRaw);
            }

            $data = $data->skip($start)
                         ->join('product_categories', 'product_sub_categories.product_category_id', 'product_categories.id')
                         ->select(['product_sub_categories.*', 'product_categories.category'])
                         ->limit($length)
                         ->get();
                         $array['data'] = [];         
            foreach($data as $row){
                $array['data'][] = array(
                    $row->id,
                    $row->subcategory,
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
            $array['recordsFiltered'] = ($whereRaw == "") ? ProductSubCategory::count() : ProductSubCategory::whereRaw($whereRaw)->count();
            $array['recordsTotal'] = ProductSubCategory::count();

            return response()->json($array);

        }

        $collumns = ['Código', 'Sub Categoria', 'Categoria', 'Data de Cadastro', 'Ações'];

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

        $model = new ProductSubCategory();
        foreach($model->getFillable() as $fillable){
            if($fillable != 'product_category_id'){
                $fillables[]        = $fillable;
                $labels[$fillable]  = $model->getLabels()[$fillable];
            }            
        }

        $fillablesSelects[$model->getLabels()['product_category_id']] = ['name' => 'product_category_id', 'values' => ProductCategory::pluck('category', 'id')];

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
            'subcategory'           => 'required',
            'product_category_id'   => 'required'
        ];
        $nomes    = [
            'subcategory'           => 'Sub Categoria',
            'product_category_id'   => 'Categoria'
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

        $data = new ProductSubCategory($dados);
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
        $data = ProductSubCategory::find($id);
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
            if($fillable != 'product_category_id'){
                $fillables[]        = $fillable;
                $labels[$fillable]  = $data->getLabels()[$fillable];
            } 
        }

        $fillablesSelects[$data->getLabels()['product_category_id']] = ['name' => 'product_category_id', 'values' => ProductCategory::pluck('category', 'id')];

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
            'subcategory'           => 'required',
            'product_category_id'   => 'required'
        ];
        $nomes    = [
            'subcategory'           => 'Sub Categoria',
            'product_category_id'   => 'Categoria'
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

        $data = ProductSubCategory::find($id);
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
        $data = ProductSubCategory::find($id);
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
