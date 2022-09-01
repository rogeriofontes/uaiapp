<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Session;
use Storage;
use Helper;
use View;
use Form;
use Auth;
use Input;
use App\Plan;
use App\Store;
use App\Product;
use App\ProductCategory;
use App\ProductSubCategory;
use App\Http\Controllers\PagSeguroController;

class FrontController extends Controller
{
    public function __construct()
    {
       //FAZER FUNÇÕES GENÊRICAS
    }

    public function index()
    {
        $seoData = array('title'        => 'UAI - O Aplicativo Que Dá Sorte',
                        'description'   => 'Descrição do site',
                        'keywords'      => 'Palavras-chave do site',
                        'ogUrl'         => url('/'),
                        'ogImage'       => url('img/logo.png'));

        return view('site/index')->with(['seoData' => $seoData]);
    }

    public function editAnnouncement($id)
    {
        $userAccess = Auth::guard('api')->user();
        
        $productCategories = ProductCategory::pluck('category', 'id');

        $product = Product::find($id);

        $seoData = array('title'        => 'UAI - O Aplicativo Que Dá Sorte',
                        'description'   => 'Descrição do site',
                        'keywords'      => 'Palavras-chave do site',
                        'ogUrl'         => url('/announcement'),
                        'ogImage'       => url('img/logo.png'));

        return view('site/edit-announcement')->with(['userAccess' => $userAccess, 'productCategories' => $productCategories, 'seoData' => $seoData, 'product' => $product]);
    }

    public function announcement()
    {
        $userAccess = Auth::guard('api')->user();

        $productCategories = ProductCategory::pluck('category', 'id');

        $seoData = array('title'        => 'UAI - O Aplicativo Que Dá Sorte',
                        'description'   => 'Descrição do site',
                        'keywords'      => 'Palavras-chave do site',
                        'ogUrl'         => url('/announcement'),
                        'ogImage'       => url('img/logo.png'));

        return view('site/announcement')->with(['userAccess' => $userAccess, 'productCategories' => $productCategories, 'seoData' => $seoData]);
    }

    public function setAnnouncement(Request $request)
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
            'content'                   => 'required',
            'image'                     => 'required'
        ];
        $nomes = [
            'type'                      => 'Tipo',
            'person_id'                 => 'Empresa',
            'status'                    => 'Status',
            'name'                      => 'Nome',
            'product_sub_category_id'   => 'Subcategoria',
            'price'                     => 'Preço',
            'content'                   => 'Descrição',
            'image'                     => 'Foto'
        ];
        $messages = [];

        $validator = Validator::make($dados, $rules, $messages);
        $validator->setAttributeNames($nomes);
  
        if ($validator->fails()) {
            Session::flash('error', true);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // verificar se é possível inserir todas as imagens
        if (count($dados['image']) > 6) {
            Session::flash('error', true);
            return redirect()->back()->withErrors('Você pode cadastrar no máximo 6 imagens.')->withInput();
        }

        $data = new Product($dados);
        $result = $data->save();

        if($result)
        {
            $files = $request->file('image');
            foreach($files as $file) {
                if($file != null) 
                {
                    $resultMedia = (new MediaController)->putMedia($file, 5000000, 1);
                    if(!$resultMedia['save'])
                    {
                        Session::flash('error', true);
                        return redirect()->back()->withErrors($resultMedia['message_error'])->withInput($dados);
                    }

                    $data->getMedias()->create([
                        'product_id'    => $data->id,
                        'media_id'      => $resultMedia['media_id']
                    ]);
                }
            }

            $file = $request->file('video');
            if($file != null) 
            {
                $resultMedia = (new MediaController)->putMedia($file, 10000000, 3);
                if(!$resultMedia['save'])
                {
                    Session::flash('error', true);
                    return redirect()->back()->withErrors($resultMedia['message_error'])->withInput($dados);
                }
    
                $data->getMedias()->create([
                    'product_id'    => $data->id,
                    'media_id'      => $resultMedia['media_id']
                ]);
            }

            Session::flash('success', true);
        }
        else
        {
            Session::flash('error', true);
        }

        return redirect()->to('/planos?api_token=' . Input::get('api_token') . '&product_id=' . $data->id);

    }

    public function updateAnnouncement(Request $request, $id)
    {
        $dados = $request->all();
        $dados['price'] = str_replace('.', '', $dados['price']);
        $dados['price'] = str_replace(',', '.', $dados['price']);

        $rules = [
            'name'                      => 'required',
            'product_sub_category_id'   => 'required',
            'price'                     => 'required|max:11',
            'content'                   => 'required'
        ];
        $nomes = [
            'name'                      => 'Nome',
            'product_sub_category_id'   => 'Subcategoria',
            'price'                     => 'Preço',
            'content'                   => 'Descrição'
        ];
        $messages = [];

        $validator = Validator::make($dados, $rules, $messages);
        $validator->setAttributeNames($nomes);
  
        if ($validator->fails()) {
            Session::flash('error', true);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = Product::find($id);

        // verificar se é possível adicionar mais imagens
        if (isset($dados['image'])) {
            $countImages = $data->getMedias()->whereHas('getMedia', function($query){ $query->where('media_type_id', 1); })->count();
            if (isset($dados['remove_img'])) {
                if (($countImages - count($dados['remove_img'])) > 6) {
                    Session::flash('error', true);
                    return redirect()->back()->withErrors('Você pode cadastrar no máximo 6 imagens.')->withInput();
                }
            } else {
                if ((count($dados['image']) + $countImages) > 6) {
                    Session::flash('error', true);
                    return redirect()->back()->withErrors('Você pode cadastrar no máximo 6 imagens.')->withInput();
                }
            }
        }

        // verificar se é possível excluir as imagens selecionadas
        if (isset($dados['remove_img'])) {
            $validateImage = false;
            $files = $request->file('image');

            if ($files) {
                foreach ($files as $file) {
                    if ($file != null) {
                        $validateImage = true;
                        break;
                    }
                }
            }
            
            if (!$validateImage) {
                if ($data->getMedias()->whereHas('getMedia', function($query){ $query->where('media_type_id', 1); })->count() == count($dados['remove_img'])) {
                    Session::flash('error', true);
                    return redirect()->back()->withErrors('O seu produto deve conter ao menos 1 imagem.')->withInput();
                } else {
                    $validateImage = true;
                }
            }
        }

        $result = $data->fill($dados)->save();

        if($result)
        {
            $files = $request->file('image');
            if ($files) {
                foreach($files as $file) {
                    if($file != null) 
                    {
                        $resultMedia = (new MediaController)->putMedia($file, 2000000, 1);
                        if(!$resultMedia['save'])
                        {
                            Session::flash('error', true);
                            return redirect()->back()->withErrors($resultMedia['message_error'])->withInput($dados);
                        }
            
                        $data->getMedias()->create([
                            'product_id'    => $data->id,
                            'media_id'      => $resultMedia['media_id']
                        ]);
                    }
                }
            }

            if (isset($dados['remove_img'])) {
                if ($validateImage) {
                    foreach($dados['remove_img'] as $img) {
                        $data->getMedias()->where('media_id', $img)->delete();
                        (new MediaController)->delMedia($img);
                    }
                }
            }

            $file = $request->file('video');
            if($file != null) 
            {
                $resultMedia = (new MediaController)->putMedia($file, 5000000, 3);
                if(!$resultMedia['save'])
                {
                    Session::flash('error', true);
                    return redirect()->back()->withErrors($resultMedia['message_error'])->withInput($dados);
                }

                $videoOld = $data->getMedias()->whereHas('getMedia', function($query){ $query->where('media_type_id', 3); })->first();
    
                $result = $data->getMedias()->create([
                    'product_id'    => $data->id,
                    'media_id'      => $resultMedia['media_id']
                ]);

                if ($result) {
                    if ($videoOld) {
                        $data->getMedias()->where('media_id', $videoOld->media_id)->delete();
                        (new MediaController)->delMedia($videoOld->media_id);
                    }
                }
            }

            if (isset($dados['remove_video'])) {
                $data->getMedias()->where('media_id', $dados['remove_video'])->delete();
                (new MediaController)->delMedia($dados['remove_video']);
            }

            Session::flash('success', true);
        }
        else
        {
            Session::flash('error', true);
        }

        return redirect()->back();
    }

    public function plan()
    {
        $userAccess = Auth::guard('api')->user();

        $plans = Plan::get();

        $seoData = array('title'        => 'UAI - Planos',
                        'description'   => 'Descrição do site',
                        'keywords'      => 'planos',
                        'ogUrl'         => url('/planos'),
                        'ogImage'       => url('img/logo.png'));

        return view('site/plan')->with(['userAccess' => $userAccess, 'plans' => $plans, 'seoData' => $seoData]);
    }

    public function checkout()
    {
        $userAccess = Auth::guard('api')->user();

        $plan = Plan::where('id', Input::get('plan_id'))->first();

        $seoData = array('title'        => 'UAI - Checkout',
                        'description'   => 'Descrição do site',
                        'keywords'      => 'checkout',
                        'ogUrl'         => url('/checkout'),
                        'ogImage'       => url('img/logo.png'));
        
        return view('site/checkout')->with(['userAccess' => $userAccess, 'plan' => $plan, 'seoData' => $seoData]);
    }

    public function setCheckout(Request $request)
    {
        $dados = $request->all();
        $userAccess = Auth::guard('api')->user();

        $rules = [
            'name'          => 'required',
            'address'       => 'required_with:cep',
            'number'        => 'required_with:cep,address', 
            'neighborhood'  => 'required_with:cep,address',
            'city_id'       => 'required_with:cep,neighborhood',
            'paymentMethod' => 'required_unless:price,0|in:1,2'
        ];
        $nomes = [
            'name'          => 'Nome Completo',
            'cep'           => 'CEP',
            'address'       => 'Endereço',
            'number'        => 'Número',
            'neighborhood'  => 'Bairro',
            'city_id'       => 'Cidade',
            'paymentMethod' => 'Forma de Pagamento',
            'price'         => 'Valor do Plano'
        ];
        
        $messages = [];
        
        $validator = Validator::make($dados, $rules, $messages);
        $validator->setAttributeNames($nomes);
        if ($validator->fails()) 
        {
            Session::flash('error', true);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $nameExplode = explode(" ", $dados['name']);

        if (count($nameExplode) < 2)
        {
            Session::flash('error', true);
            $validator->errors()->add('Nome', 'Por favor digite seu nome completo');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $userAccess->getPerson->fill($dados)->save();

        if ($userAccess->getPerson->getAddress)
        {
            $userAccess->getPerson->getAddress->fill($dados)->save();
        }
        else
        {
            $userAccess->getPerson->getAddress()->create($dados);
        }

        if(isset($dados['paymentMethod'])){
            if($dados['paymentMethod'] == '2')
            {
                $dados['plan_id'] = Input::get('plan_id');
                $dados['product_id'] = Input::get('product_id');
                $checkout = (new PagSeguroController)->payment($dados, $userAccess);

                return $this->checkoutSuccess($checkout);
            }
            else
            {
                return redirect()->to('/cartao?api_token=' . $userAccess->api_token . '&product_id=' . Input::get('product_id') . '&plan_id=' . Input::get('plan_id'));
            }
        }else{
            $dados['plan_id'] = Input::get('plan_id');
            $dados['product_id'] = Input::get('product_id');
            $checkout = (new PagSeguroController)->payment($dados, $userAccess);

            return $this->checkoutSuccess($checkout);
        }
    }

    public function creditCard()
    {
        $userAccess = Auth::guard('api')->user();

        $seoData = array('title'        => 'UAI - Pagamento',
                        'description'   => 'Descrição do site',
                        'keywords'      => '',
                        'ogUrl'         => url('/cartao'),
                        'ogImage'       => url('img/logo.png'));

        return view('site/credit-card')->with(['userAccess' => $userAccess, 'seoData' => $seoData]);
    }

    public function setCreditCard(Request $request)
    {
        $dados = $request->all();
        $userAccess = Auth::guard('api')->user();

        $rules = [
            'number'            => 'required',
            'expiry_mm'         => 'required',
            'expiry_aa'         => 'required',
            'name'              => 'required',
            'cvc'               => 'required',
            'senderHash'        => 'required',
            'creditCardToken'   => 'required',
            'cpf_cnpj'          => 'required'
        ];
        $nomes = [
            'number'            => 'Número do cartão',
            'expiry_mm'         => 'Mês de validade',
            'expiry_aa'         => 'Ano de validade',
            'name'              => 'Títular do cartão',
            'cvc'               => 'Código de Segurança',
            'senderHash'        => 'Token do PagSeguro',
            'creditCardToken'   => 'Token do Cartão',
            'cpf_cnpj'          => 'CPF'
        ];

        $messages = [];

        $validator = Validator::make($dados, $rules, $messages);
        $validator->setAttributeNames($nomes);

        if ($validator->fails())
        {
            Session::flash('error', true);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $dados['paymentMethod'] = '1';
        $dados['plan_id'] = Input::get('plan_id');
        $dados['product_id'] = Input::get('product_id');
        $checkout = (new PagSeguroController)->payment($dados, $userAccess);
        
        return $this->checkoutSuccess($checkout);
    }

    public function checkoutSuccess($checkout = null)
    {
        $userAccess = Auth::guard('api')->user();

        $seoData = array('title'        => 'UAI - Sucesso de Checkout',
                        'description'   => 'Descrição do site',
                        'keywords'      => 'sucesso de checkout',
                        'ogUrl'         => url('/checkout/sucesso'),
                        'ogImage'       => url('img/logo.png'));
        
        return view('site/checkout-success')->with(['userAccess' => $userAccess, 'seoData' => $seoData, 'checkout' => $checkout]);
    }
}
