<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helper;
use Validator;
use View;
use Session;
use Form;
use Storage;
use App\Banner;
use App\Media;

class BannerController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->pagina       = "Banner";
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
            $collumns = ['id', 'title', 'link', 'media_id', 'created_at'];

            $orderColumn = $_GET['order'][0]['column'];
            $oderDir     = $_GET['order'][0]['dir'];
            $start       = $_GET['start'];
            $length      = $_GET['length'];
            $search      = $_GET['search']['value'];

            $data = Banner::orderByRaw($collumns[$orderColumn] . ' ' . $oderDir);
            
            $whereRaw = "";
            if($search != ""){
                $whereRaw = 'title  LIKE "%' .$search. '%"';
                $data->whereRaw($whereRaw);
            }

            $data = $data->skip($start)
                         ->limit($length)
                         ->get();

                         $array['data'] = [];
            foreach($data as $row){
                $array['data'][] = array(
                    $row->id,
                    '<img src="'.Storage::disk('public')->url($row->getMedia->thumbnail_path).'" class="img-responsive center-block" style="height: 50px;"/>',
                    $row->title,
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
            $array['recordsFiltered'] = ($whereRaw == "") ? Banner::count() : Banner::whereRaw($whereRaw)->count();
            $array['recordsTotal'] = Banner::count();

            return response()->json($array);

        }        

        $collumns = ['Código', 'Imagem', 'Título', 'Data de Cadastro', 'Ação'];

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

        $model = new Banner();
        foreach($model->getFillable() as $fillable){
            $fillables[] = $fillable;
            $labels[$fillable] = $model->getLabels()[$fillable];
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

        $rules = [
            'title'     => 'required',
            'media_id'  => 'required|mimes:jpg,jpeg,png'
        ];
        $nomes = [
            'title'     => 'Título',
            'media_id'  => 'Imagem'
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

        if (isset($dados['link']))
        {
            $link = explode('http://', $dados['link'], 2);
            if(count($link) == 1){
                $link = explode('https://', $dados['link'], 2);
            }

            if (count($link) > 1)
            {
                $dados['link'] = $link[1];
            }
            else
            {
                $dados['link'] = $link[0];
            }
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

        $data = new Banner($dados);
        $result = $data->save();

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
        //
    }

    public function edit($id)
    {
        $data = Banner::find($id);
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

        $model = new Banner();
        foreach($model->getFillable() as $fillable){
            if($fillable != 'media_id'){
                $fillables[] = $fillable;
                $labels[$fillable]  = $model->getLabels()[$fillable];
            } 
            else if($fillable == 'media_id'){
                $otherElements .= '<div class="form-group">';
                $otherElements .= Form::label($fillable, ucwords($model->getLabels()[$fillable]), ['class' => 'col-sm-2 control-label']);
                $otherElements .= ' <div class="col-sm-8">';
                $otherElements .= Form::file('file', ['class' => 'form-control']);
                $otherElements .= Form::hidden($fillable, $data[$fillable]);
                $otherElements .= '</div>';
                $otherElements .= '</div>';
                $otherElements .= '<div class="form-group">';
                $otherElements .= '<div class="col-sm-2">';
                $otherElements .= '</div>';
                $otherElements .= '<div class="col-sm-8">';
                $otherElements .= '<img src="'.Storage::disk('public')->url($data->getMedia->path).'" class="img-responsive" />';
                $otherElements .= '</div>';
                $otherElements .= '</div>';
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

    public function update(Request $request, $id)
    {
        $dados = $request->all();
        
        $rules    = [
            'title'     => 'required',
        ];
        $nomes    = [
            'title'     => 'Título',
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

        if (isset($dados['link']))
        {
            $link = explode('http://', $dados['link'], 2);
            if(count($link) == 1){
                $link = explode('https://', $dados['link'], 2);
            }

            if (count($link) > 1)
            {
                $dados['link'] = $link[1];
            }
            else
            {
                $dados['link'] = $link[0];
            }
        }

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

        $data = Banner::find($id);

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

        return redirect()->back();
    }

    public function destroy($id)
    {
        $data = Banner::find($id);
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
