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
use App\Notification;
use App\Fcm;
use App\NotificationHasFcm;

class NotificationController extends Controller
{
    public function __construct()
    {        
        parent::__construct();

        $this->pagina        = "Notificação";
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
            $collumns = ['id', 'title', 'category', 'date', 'success', 'failure', 'created_at'];

            $orderColumn = $_GET['order'][0]['column'];
            $oderDir     = $_GET['order'][0]['dir'];
            $start       = $_GET['start'];
            $length      = $_GET['length'];
            $search      = $_GET['search']['value'];

            $data = Notification::orderByRaw($collumns[$orderColumn] . ' ' . $oderDir);
            
            $whereRaw = "";
            if($search != ""){
                $whereRaw = '(notification LIKE "%' .$search. '%")';       
                $data->whereRaw($whereRaw);
            }

            $dataWhere = clone($data);

            $data = $data->skip($start)
                         ->limit($length)
                         ->get();

            $array['data'] = array();             
            
            foreach($data as $row){
                $array['data'][] = array(
                    $row->id,
                    $row->title,
                    $row->getCategory(),
                    $row->created_at->format('d/m/Y H:i:s'),
                    $row->success,
                    $row->failure,
                    '<a title="Visualizar" data-toggle="tooltip" data-placement="top" href="' . route($this->route . '.show', $row->id) . '" class="btn btn-xs btn-edit"> <i class="fas fa-eye"></i> Visualizar</a>'
                );
            }

            $array['draw'] = $_GET['draw'];
            $array['recordsFiltered'] = $dataWhere->count();
            $array['recordsTotal'] = Notification::count();

            return response()->json($array);

        }

        $collumns = ['Código', 'Título', 'Categoria', 'Data', 'Success', 'Failure', 'Ações'];

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

        $model = new Notification();
        foreach($model->getFillable() as $fillable){
            if($fillable != 'category' && $fillable != 'type_link' && $fillable != 'hour' && $fillable != 'date' && $fillable != 'success' && $fillable != 'failure'){
                $fillables[] = $fillable;
                $labels[$fillable] = $model->getLabels()[$fillable];
            }
        }

        $fillablesSelects['Tipo de link'] = ['name' => 'type_link', 'values' => ['E' => 'Externo', 'I' => 'Interno']];
        $fillablesSelects['Categoria'] = ['name' => 'category', 'values' => ['A' => 'Anúncios',
                                                                            'N' => 'Notícias']];        

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
            'title'     => 'required',
            'content'   => 'required',
            'category'  => 'required',
            'type_link' => 'required'
        ];
        $nomes    = [
            'title'     => 'Título',
            'content'   => 'Conteúdo',
            'link'      => 'Link',
            'date'      => 'Data',
            'hour'      => 'Hora',
            'category'  => 'Categoria',
            'type_link' => 'Tipo de link'
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

        $dados['date'] = date('Y-m-d');
        $dados['hour'] = date('H:i:s');

        $notification = new Notification($dados);
        $notification->save();

        $fields = array(
            'registration_ids'  => Fcm::pluck('token')->all(),
            'data'              => [ "notification" => [
                                        'date'      => $notification->getDate(),
                                        'hour'      => $notification->getHour(),
                                        'link'      => $notification->link,
                                        'type_link' => $notification->type_link,
                                        'category'  => $notification->category,
                                        'title'     => $notification->title,
                                        'content'   => $notification->content,
                                        'visualized'=> false
                                        ]
                                   ]
        );
        
        $result = \sendNotification($fields);
        
        if($result['exec']){
            Session::flash('success', true);           

            $validator->errors()->add('FCM', $result['msg']);

            $json = json_decode($result['msg']);

            $notification->success = $json->success;
            $notification->failure = $json->failure;
            $notification->update();
            
            $fcms = Fcm::select('id as fcm_id', DB::raw($notification->id . ' as notification_id'))->get()->toArray();
            $result = NotificationHasFcm::insert($fcms);
            
            return redirect()->back()->withErrors($validator);
        }else{
            Session::flash('error', true);

            $validator->errors()->add('FCM', $result['msg']);

            $notification->forceDelete();

            return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
        }
        
    }

    public function show($id)
    {
        $this->breadcrumb[] = ['route' => $this->route, 'pagina' => 'Visualizar'];
        $fillables          = array();
        $fillablesSelects   = array();
        $labels             = array();
        $otherElements      = '';        
        $scripts            = '';
        $css                = '';

        $data = Notification::find($id);
        if(!$data){
            abort(404, 'Notificação não encontrada');
        }

        return view(\Route::getCurrentRoute()->getPrefix() . '.notification.show')
                ->with([
                        'notification'      => $data,
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
}
