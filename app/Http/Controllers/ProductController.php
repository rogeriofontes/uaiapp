<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helper;
use Validator;
use View;
use Session;
use Form;
use Storage;
use App\Product;
use App\ProductCategory;
use App\Store;
use App\ProductSubCategory;

class ProductController extends Controller
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
            $collumns = ['id', 'name', 'product_sub_category_id', 'price', 'content', 'status', 'type', 'person_id', 'created_at'];

            $orderColumn = $_GET['order'][0]['column'];
            $oderDir     = $_GET['order'][0]['dir'];
            $start       = $_GET['start'];
            $length      = $_GET['length'];
            $search      = $_GET['search']['value'];

            $data = Product::orderByRaw($collumns[$orderColumn] . ' ' . $oderDir);
            
            $whereRaw = "";
            if($search != ""){
                $whereRaw = '(products.name LIKE "%' .$search. '%" OR 
                              product_sub_categories.subcategory LIKE "%' .$search. '%" OR 
                              product_categories.category LIKE "%' .$search. '%" OR 
                              people.name LIKE "%' .$search. '%"
                              )';
                $data->whereRaw($whereRaw);
            }

            $data = $data->skip($start)
                         ->join('product_sub_categories', 'products.product_sub_category_id', 'product_sub_categories.id')
                         ->join('product_categories', 'product_sub_categories.product_category_id', 'product_categories.id')
                         ->join('people', 'products.person_id', 'people.id')
                         ->limit($length)
                         ->select('products.*', 'product_sub_categories.subcategory as subcategory', 'product_categories.category as category', 'people.name as store');
            
            $dataWhere = clone($data);

            $data = $data->get();
            $array['data'] = [];
            foreach($data as $row){
                $imgPath = ($row->getMedias()->first()) ? Storage::disk('public')->url($row->getMedias()->first()->getMedia->thumbnail_path) : asset('img/image_not_found.jpg');
                $actions = ($row->type == 'A')
                ?
                '<a title="Visualizar" data-toggle="tooltip" data-placement="top" href="' . route($this->route . '.show', $row->id) . '" class="btn-success btn btn-xs m-l-xs m-r-xs"> <i class="fa fa-eye"></i> Visualizar</a>'
                :
                '<a title="Editar" data-toggle="tooltip" data-placement="top" href="' . route($this->route . '.edit', $row->id) . '" class="btn-success btn btn-xs m-l-xs m-r-xs"> <i class="fa fa-pencil"></i> Editar</a>';

                $actions .= '<a title="Excluir" data-toggle="tooltip" data-placement="top" class="label-danger btn btn-xs btn-del m-l-xs m-r-xs">
                            <i class="fa fa-trash"></i> Excluir'
                            .Form::open(['method'=>'DELETE', 'route'=>[ $this->route .'.destroy', $row->id], 'class'=>'form-delete', 'style' => 'display: none']) 
                            .Form::close()
                            .'</a>';
                            
                $actions .= ($row->status == '0') 
                ? 
                Form::open(['method'=>'PUT', 'route'=>[ $this->route .'.update', $row->id], 'class'=>'inline m-l-xs m-r-xs'])
                .Form::hidden('update_status', 1)
                .Form::hidden('status', 1)
                .'<button title="Desbloquear" data-toggle="tooltip" data-placement="top" type="submit" class="btn-warning btn btn-xs"> <i class="fa fa-lock"></i></button>'
                .Form::close()
                :
                Form::open(['method'=>'PUT', 'route'=>[ $this->route .'.update', $row->id], 'class'=>'inline m-l-xs m-r-xs'])
                .Form::hidden('update_status', 1)
                .Form::hidden('status', 0)
                .'<button title="Bloquear" data-toggle="tooltip" data-placement="top" type="submit" class="btn-warning btn btn-xs"> <i class="fa fa-unlock"></i></button>'
                .Form::close();

                $array['data'][] = array(
                    $row->id,
                    '<img style="height:50px" src="'. $imgPath .'" class="img-responsive" />',
                    $row->name,
                    $row->category,
                    $row->subcategory,
                    $row->store,
                    $row->created_at->format('d/m/Y H:i:s'),
                    $actions
                );
            }

            $array['draw'] = $_GET['draw'];
            $array['recordsFiltered'] = ($whereRaw == "") ? Product::count() : $dataWhere->whereRaw($whereRaw)->count();
            $array['recordsTotal'] = Product::count();

            return response()->json($array);

        }

        $collumns = ['Código', 'Foto', 'Produto', 'Categoria', 'Sub Categoria', 'Pessoa', 'Data de Cadastro', 'Ações'];

        return view(\Route::getCurrentRoute()->getPrefix() . '.simple.list')
                    ->with([
                        'collumns' => $collumns,
                        'breadcrumb' => $this->breadcrumb
                    ]);
    }

    public function create()
    {
        $this->breadcrumb[] = ['route' => $this->route, 'pagina' => 'Adicionar'];
        $productCategories = ProductCategory::pluck('category', 'id');
        $stores = Store::join('people', 'stores.person_id', 'people.id')->pluck('people.name', 'stores.person_id');
        
        return view(\Route::getCurrentRoute()->getPrefix() . '.product.create')
                    ->with([
                        'breadcrumb'        => $this->breadcrumb,
                        'gallery'           => false,
                        'productCategories' => $productCategories,
                        'stores'            => $stores
                    ]);
    }

    public function store(Request $request)
    {
        $dados = $request->all();
        $dados['price'] = str_replace('.', '', $dados['price']);
        $dados['price'] = str_replace(',', '.', $dados['price']);

        $rules = [
            'type'                      => 'required',
            'person_id'                 => 'required',
            'status'                    => 'required',
            'name'                      => 'required',
            'product_sub_category_id'   => 'required',
            'price'                     => 'required|max:11',
            'content'                   => 'required'
        ];
        $nomes = [
            'type'                      => 'Tipo',
            'person_id'                 => 'Empresa',
            'status'                    => 'Status',
            'name'                      => 'Nome',
            'product_sub_category_id'   => 'Subcategoria',
            'price'                     => 'Preço',
            'content'                   => 'Descrição'
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

        $data = new Product($dados);
        $result = $data->save();

        if($result)
        {   
            Session::flash('success', true);

            return redirect()->route($this->route . '.edit', $data->id);
        }
        else
        {
            Session::flash('error', true);
        }

        return redirect()->back();
    }

    public function edit($id)
    {
        $data = Product::find($id);
        if($data == null || $data->type == 'A')
        {
            abort(404);
        }

        $this->breadcrumb[] = ['route' => $this->route, 'pagina' => 'Editar'];
        $productCategories = ProductCategory::pluck('category', 'id');
        $productSubcategories = ProductSubCategory::where('product_category_id', $data->getProductSubCategory->getProductCategory->id)->pluck('subcategory', 'id');
        $stores = Store::join('people', 'stores.person_id', 'people.id')->pluck('people.name', 'stores.person_id');

        return view(\Route::getCurrentRoute()->getPrefix() . '.product.edit')
                    ->with([
                        'breadcrumb'            => $this->breadcrumb,
                        'data'                  => $data,
                        'productCategories'     => $productCategories,
                        'stores'                => $stores,
                        'productSubcategories'  => $productSubcategories
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

        if (!isset($dados['update_status'])) {
            $dados['price'] = str_replace('.', '', $dados['price']);
            $dados['price'] = str_replace(',', '.', $dados['price']);

            $rules = [
                'type'                      => 'required',
                'person_id'                 => 'required',
                'status'                    => 'required',
                'name'                      => 'required',
                'product_sub_category_id'   => 'required',
                'price'                     => 'required|max:11',
                'content'                   => 'required'
            ];
            $nomes = [
                'type'                      => 'Tipo',
                'person_id'                 => 'Empresa',
                'status'                    => 'Status',
                'name'                      => 'Nome',
                'product_sub_category_id'   => 'Subcategoria',
                'price'                     => 'Preço',
                'content'                   => 'Descrição'
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
        }

        $data = Product::find($id);
        $result = $data->fill($dados)->save();

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

    public function show($id)
    {
        $product = Product::find($id);
        if($product == null){
            abort(404, 'Produto não encontrado.');
        }
        
        
        $this->breadcrumb[] = ['route' => $this->route, 'pagina' => 'Visualizar'];
        $otherElements      = '';        
        $scripts            = '';
        $css                = '';

        return view(\Route::getCurrentRoute()->getPrefix() . '.product.show')
        ->with([
            'breadcrumb'        => $this->breadcrumb,
            'otherElements'     => $otherElements,
            'scripts'           => $scripts,
            'css'               => $css,
            'product'           => $product,
        ]);
    
    }

    public function destroy($id)
    {
        $data = Product::find($id);
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
