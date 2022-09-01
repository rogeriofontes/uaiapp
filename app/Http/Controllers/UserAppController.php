<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helper;
use View;
use Form;
use App\UserApp;
use App\User;

class UserAppController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->pagina        = "Usuários Aplicativo";
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
            $collumns = ['id', 'person_id', 'token', 'status', 'created_at'];

            $orderColumn = $_GET['order'][0]['column'];
            $oderDir     = $_GET['order'][0]['dir'];
            $start       = $_GET['start'];
            $length      = $_GET['length'];
            $search      = $_GET['search']['value'];

            $data = UserApp::orderByRaw($collumns[$orderColumn] . ' ' . $oderDir);
            
            $whereRaw = "";
            if($search != ""){
                $whereRaw = '(people.name LIKE "%' .str_replace(" ", "%", $search). '%" OR users.phone LIKE "%' .str_replace(" ", "%", $search). '%")';
                $data->whereRaw($whereRaw);
            }

            $data = $data->skip($start)
                         ->join('people', 'people.id', 'user_apps.person_id')
                         ->join('users', 'people.user_id', 'users.id')
                         ->limit($length)
                         ->select(['user_apps.*', 'people.name', 'users.phone']);

            $dataWhere = clone($data);

            $data = $data->get();

            $array['data'] = [];
            foreach($data as $row){
                $array['data'][] = array(
                    $row->id,
                    $row->name,
                    $row->phone,
                    $row->created_at->format('d/m/Y H:i:s'),
                    '<a title="Visualizar" data-toggle="tooltip" data-placement="top" href="' . route($this->route . '.show', $row->id) . '" class="btn-success btn btn-xs"> <i class="fa fa-eye"></i> Visualizar</a>
                    <a title="Excluir" data-toggle="tooltip" data-placement="top" class="label-danger btn btn-xs btn-del">
                    <i class="fa fa-trash"></i> Excluir'
                    .Form::open(['method'=>'DELETE', 'route'=>[ $this->route .'.destroy', $row->id], 'class'=>'form-delete', 'style' => 'display: none']) 
                    .Form::close()
                    .'</a>'                    
                );
            }

            $array['draw'] = $_GET['draw'];
            $array['recordsFiltered'] = ($whereRaw == "") ? UserApp::count() : $dataWhere->whereRaw($whereRaw)->count();
            $array['recordsTotal'] = UserApp::count();

            return response()->json($array);

        }

        $collumns = ['Código', 'Nome', 'Telefone', 'Data de Cadastro', 'Ações'];

        return view(\Route::getCurrentRoute()->getPrefix() . '.simple.list')
                    ->with([
                        'collumns' => $collumns,
                        'breadcrumb' => $this->breadcrumb
                    ]);
    }

    public function create()
    {
        return redirect()->back();
    }

    public function show($id)
    {
        $userApp = UserApp::find($id);
        if($userApp == null)
        {
            abort(404, "Usuário não encontrado");
        }

        $this->breadcrumb[] = ['route' => $this->route, 'pagina' => 'Visualizar'];
        $otherElements      = '';        
        $scripts            = '';
        $css                = '';

        return view(\Route::getCurrentRoute()->getPrefix() . '.user-app.show')
        ->with([
            'breadcrumb'        => $this->breadcrumb,
            'otherElements'     => $otherElements,
            'scripts'           => $scripts,
            'css'               => $css,
            'userApp'          => $userApp,
        ]);
    }

    public function destroy($id)
    {
        $data = UserApp::find($id);
        $result = $data->forceDelete();

        if($result)
        {
            $idUser = $data->getPerson->user_id;
            if($data->getPerson()->forceDelete()){
                User::find($idUser)->forceDelete();
            }

            return response()->json(true);
        }
        else
        {
            return response()->json(false);
        }     
    }
}
