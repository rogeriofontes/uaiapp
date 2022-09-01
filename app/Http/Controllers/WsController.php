<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\ProductCategory;
use App\Product;
use App\User;
use App\Person;
use App\UserApp;
use App\Phone;
use App\ProductHasInterest;
use App\Media;
use App\PasswordReset;
use App\Store;
use App\Banner;
use DB;
use Storage;
use Hash;
use Auth;
use Mail;
use Image;

class WsController extends Controller
{
    public function __construct()
    {
       //FAZER FUNÇÕES GENÊRICAS
    }

    public function getNews()
    {
        return News::select([
                        'news.id',
                        DB::raw('DATE_FORMAT(STR_TO_DATE(news.date, "%Y-%m-%d"), "%d/%m/%Y") as data'),
                        'news.title',
                        'news.subtitle',
                        'news.content',
                        'news_categories.category',
                        DB::raw('CONCAT("'. Storage::disk('public')->url('/') . '",media.thumbnail_path) AS thumbnail'),
                        DB::raw('CONCAT("'. Storage::disk('public')->url('/') . '",media.path) AS media'),
                    ])
                    ->join('news_categories', 'news.news_category_id', 'news_categories.id')
                    ->join('media', 'news.media_id', 'media.id')
                    ->limit(20)
                    ->orderBy('date', true)
                    ->get();
    }

    public function getProductCategory()
    {
        return ProductCategory::select([
                                'product_categories.id',
                                'product_categories.category',
                                DB::raw('CONCAT("'. Storage::disk('public')->url('/') . '",media.thumbnail_path) AS thumbnail'),
                                DB::raw('CONCAT("'. Storage::disk('public')->url('/') . '",media.path) AS media'),
                                ])
                                ->join('media', 'product_categories.media_id', 'media.id')
                                ->with('getProductSubCategory')->get();
    }

    public function authenticate(Request $request)
    {
      $credentials = $request->json()->all();
      $credentials['phone']      = cleanString($credentials['phone']);

      $user = User::where('phone', $credentials['phone'])->first();
      
      if(!$user) {
        return response()->json([
          'message' => 'Telefone não cadastrado.',
        ], 200);
      }

      if($user->getPerson->getUserApp->status == '0'){
        return response()->json([
            'message' => 'Usuário não validado. Caso não recebeu o SMS, clique em enviar novamente.',
            'status'  => false
          ], 200);
      }

      if (!Hash::check($credentials['password'], $user->password)) {
          return response()->json([
            'message' => 'Sua senha está incorreta!',
          ], 200);
      }

      if (!Auth::attempt(array('phone' => $credentials['phone'], 'password' => $credentials['password']), true))
      {
        return response()->json([
          'message' => 'Login Failed.'
        ], 200);
      }

      return User::select([
                            'users.id',
                            'people.name',
                            'users.phone',
                            'users.email',
                            'people.cpf_cnpj',
                            'people.ie',
                            'people.type_person',
                            'users.api_token',
                            'user_apps.status'
                        ])
                        ->join('people', 'people.user_id', 'users.id')
                        ->join('user_apps', 'user_apps.person_id', 'people.id')
                        ->where('phone', $credentials['phone'])
                        ->first();

    }

    public function validateUser(Request $request)
    {
        $json = $request->json()->all();

        $userApp = UserApp::whereToken($json['token'])->first();

        if(!$userApp) return response()->json(["message" => 'Token não encontrado!', 'error' => true]);

        $userApp->token = '';
        $userApp->status = '1';
        $result = $userApp->update();

        if($result){
            return response()->json(["message" => 'Usuário validado com sucesso.', 'error' => false]);
        }

        return response()->json(["message" => 'Ops! Ocorreu um erro ao validar o usuário.', 'error' => true]);
    }   

    public function recoverValidate(Request $request)
    {
        $json = $request->json()->all();
        $json['phone']      = cleanString($json['phone']);
        $token = strtoupper(substr(md5(time()),0, 6));
        $json['token']      = $token;

        $user = User::where('phone', $json['phone'])->first();

        if(!$user) return response()->json(["message" => 'Telefone não encontrado', 'error' => true]);

        $user->getPerson->getUserApp->token = $token;

        $result = $user->getPerson->getUserApp->save();

        if($result){

            
            $msgEncoded = urlencode("Seu token para validar seu cadastro do UAI APP: " . $token);
            $urlChamada = "https://www.facilitamovel.com.br/api/simpleSend.ft?user=Uai%20app&password=uai2018&destinatario=".$json['phone']."&msg=".$msgEncoded;
            $contents =  file_get_contents($urlChamada);
            
            return response()->json(["message" => 'Token enviado com sucesso.', 'error' => false]);
        }

        return response()->json(["message" => 'Ops! Ocorreu um erro ao enviar token.', 'error' => true]);

    }

    public function register(Request $request)
    {
        $json = $request->json()->all();
        $json['password']   = bcrypt($json['password']);
        $json['phone']      = cleanString($json['phone']);
        $token = strtoupper(substr(md5(time()),0, 6));
        $json['token']      = $token;

        $user = User::where('phone', $json['phone'])->first();

        if($user == null)
        {
            $user   = new User();
            $user->generateApiToken();
            $result = $user->fill($json)->save();

            $person = new Person();
            $person->fill($json);
            $result = $user->getPerson()->save($person);

            $userApp = new UserApp();
            $userApp->fill($json);            
            $result = $user->getPerson->getUserApp()->save($userApp);

            if($result)
            {
                $msgEncoded = urlencode("Seu token para validar seu cadastro do UAI APP: " . $token);
                $urlChamada = "https://www.facilitamovel.com.br/api/simpleSend.ft?user=Uai%20app&password=uai2018&destinatario=".$json['phone']."&msg=".$msgEncoded;
                $contents =  file_get_contents($urlChamada);
                
                return User::select([
                                'users.id',
                                'people.name',
                                'users.phone',
                                'users.api_token'
                            ])
                            ->join('people', 'people.user_id', 'users.id')
                            ->join('user_apps', 'user_apps.person_id', 'people.id')
                            ->where('users.phone', $json['phone'])
                            ->first();
            }
            else 
            {
                return response()->json(["message" => "Error ao cadastrar usuário."]);
            }
        } 
        else 
        {
            return response()->json(["message" => "Telefone já cadastrado", "user" => null]);
        }
    }

    public function alterUser(Request $request)
    {
        $json = $request->json()->all();
        if(isset($json['password'])){
            $json['password']   = bcrypt($json['password']);
        }        
        $json['phone']      = cleanString($json['phone']);

        $user = User::where('phone', $json['phone'])->first();

        if(!$user) return response()->json(["message" => "Usuário não encontrado", "error" => true]);

        $user->fill($json)->save();
        $user->getPerson->fill($json)->save();
        $user->getPerson->getUserApp->fill($json)->save();

        return response()->json(["message" => "Usuário atualizado com sucesso", "error" => false]);

    }

    public function forgotPassword(Request $request)
    {
        $json = $request->json()->all();
        $json['phone']      = cleanString($json['phone']);

        $user = User::where('phone', $json['phone'])->first();

        if(!$user) return response()->json(["message" => 'Telefone não encontrado!', 'error' => true]);

        PasswordReset::where('phone', $json['phone'])->delete();

        $token = strtoupper(substr(md5(time()),0, 6));
        $passwordReset = PasswordReset::create([
            'phone' => $json['phone'],
            'token' => $token
        ]);

        $msgEncoded = urlencode("Seu token para recuperar a senha do UAI APP: " . $token);
        $urlChamada = "https://www.facilitamovel.com.br/api/simpleSend.ft?user=Uai%20app&password=uai2018&destinatario=".$json['phone']."&msg=".$msgEncoded;
        $contents =  file_get_contents($urlChamada);

        return response()->json(["message" => "SMS enviado com sucesso!", "error" => false, 'contents' => $contents]);
    }

    public function recoverPassword(Request $request)
    {
        $json = $request->json()->all();

        $passwordReset = PasswordReset::whereToken($json['token'])->first();

        if(!$passwordReset) return response()->json(["message" => 'Token não encontrado!', 'error' => true]);

        $user = User::wherePhone($passwordReset->phone)->first();

        if(!$user) return response()->json(["message" => 'Usuário não encontrado!', 'error' => true]);

        $user->password = bcrypt($json['password']);
        $result = $user->update();

        if($result){
            PasswordReset::whereToken($json['token'])->delete();
            return response()->json(["message" => 'Senha alterada com sucesso', 'error' => false]);
        }

        return response()->json(["message" => 'Ops! Ocorreu um erro ao alterar a senha.', 'error' => true]);
    }
   
    public function getProducts($subCategory)
    {
        $products =  Product::where('product_sub_category_id', $subCategory)
                        ->where('status', '1')
                        ->whereRaw('DATE(NOW()) <= date_end')
                        ->get();
        
        $arrayProducts = array();
        foreach($products as $key => $product){
            $arrayProducts[$key]['id']              = $product->id;
            $arrayProducts[$key]['advertiser']      = $product->getPerson->name;
            $arrayProducts[$key]['phone']           = $product->getPerson->getUser->phone;
            $arrayProducts[$key]['product_sub_category_id'] = $product->product_sub_category_id;
            $arrayProducts[$key]['name']            = $product->name;
            $arrayProducts[$key]['category']        = $product->getProductSubCategory->getProductCategory->category;
            $arrayProducts[$key]['subcategory']     = $product->getProductSubCategory->subcategory;
            $arrayProducts[$key]['price']           = $product->getPrice();
            $arrayProducts[$key]['content']         = $product->content;
            $arrayProducts[$key]['movie']           = ($product->getMedias()->whereHas('getMedia', function($query){
                                                            $query->where('media_type_id', 3);
                                                        })->first())?  Storage::disk('public')->url($product->getMedias()->whereHas('getMedia', function($query){
                                                            $query->where('media_type_id', 3);
                                                        })->first()->getMedia->path): NULL;

            $pictures = $product->getMedias()->whereHas('getMedia', function($query){
                                $query->where('media_type_id', 1);
                        })->get();

            $arrayProducts[$key]['pictures'] = array();
            foreach($pictures as $jey => $media){
                $arrayProducts[$key]['pictures'][$jey]['thumbnail'] = Storage::disk('public')->url($media->getMedia->thumbnail_path);
                $arrayProducts[$key]['pictures'][$jey]['media']     = Storage::disk('public')->url($media->getMedia->path);
            }
        }

        return $arrayProducts;
    }

    public function setWantProduct(Request $request, $idProduct)
    {
        $userAccess = Auth::guard('api')->user();       

        if(ProductHasInterest::firstOrCreate([
            'user_app_id'   => $userAccess->getPerson->getUserApp->id,
            'product_id'    => $idProduct
        ])){
            return response()->json(["message" => "Obrigado pelo interesse, em breve entraremos em contato.", 'error' => true]);
        }else{
            return response()->json(["message" => "Error ao cadastrar interesse.", 'error' => false]);
        }
    }

    public function setProduct(Request $request)
    {
        $json = $request->json()->all();
        $userAccess = Auth::guard('api')->user();   

        $json['person_id'] = $userAccess->getPerson->id;

        $product = Product::create($json);

        if($product){

            foreach($json['productHasMediasList'] as $media){

                // Save thumbnail
                $thumb = Image::make(base64_decode($media['media']))->fit(384, 216)->encode('jpg');
                $hashThumb = md5(microtime() . $thumb->__toString());
                $pathThumb = "pictures/{$hashThumb}.jpg";
                $storageThumb = Storage::disk('public')->put($pathThumb, $thumb->__toString());

                // Save file
                $hashMedia = sha1(microtime() . $thumb->__toString());
                $pathMedia = "pictures/{$hashMedia}.jpg";
                $storage = Storage::disk('public')->put($pathMedia, base64_decode($media['media']));

                $media = new Media(array(
                    'media_type_id'  => 1,
                    'media'          => $hashThumb,
                    'path'           => $pathMedia,
                    'thumbnail_path' => $pathThumb
                ));

                $media->save();

                $product->getMedias()->create([
                    'media_id' => $media->id
                ]);
            }            

            return response()->json(["message" => "Obrigado pelo cadastro, boas vendas.", 'error' => true]);
        }else{
            return response()->json(["message" => "Error ao cadastrar a venda.", 'error' => false]);
        }
    }

    public function getStore()
    {
        return Store::select([
                    'stores.id',
                    'people.name',
                    'people.type_person',
                    'people.cpf_cnpj',
                    'people.ie',
                    'users.email',
                    'users.phone',
                    'addresses.cep',
                    'addresses.address',
                    'addresses.neighborhood',
                    'addresses.number',
                    'addresses.complement',
                    'addresses.latitude',
                    'addresses.longitude',
                    'cities.city',
                    'states.state',
                    DB::raw('CONCAT("'. Storage::disk('public')->url('/') . '",media.thumbnail_path) AS thumbnail'),
                    DB::raw('CONCAT("'. Storage::disk('public')->url('/') . '",media.path) AS media'),
                ])
                ->join('people', 'stores.person_id', 'people.id')
                ->join('addresses', 'people.id', 'addresses.person_id')
                ->join('cities', 'addresses.city_id', 'cities.id')
                ->join('states', 'cities.state_id', 'states.id')
                ->join('users', 'people.user_id', 'users.id')
                ->join('media', 'people.media_id', 'media.id')
                ->get();
    }

    public function getStoreProducts($id)
    {
        $store = Store::find($id);

        $products =  Product::where('person_id', $store->person_id)
            ->where('status', '1')
            ->get();

        $arrayProducts = array();
        foreach($products as $key => $product){
            $arrayProducts[$key]['id']              = $product->id;
            $arrayProducts[$key]['product_sub_category_id'] = $product->product_sub_category_id;
            $arrayProducts[$key]['name']            = $product->name;
            $arrayProducts[$key]['category']        = $product->getProductSubCategory->getProductCategory->category;
            $arrayProducts[$key]['subcategory']     = $product->getProductSubCategory->subcategory;
            $arrayProducts[$key]['price']           = $product->getPrice();
            $arrayProducts[$key]['content']         = $product->content;

            foreach($product->getMedias as $jey => $media){
                $arrayProducts[$key]['pictures'][$jey]['thumbnail'] = Storage::disk('public')->url($media->getMedia->thumbnail_path);
                $arrayProducts[$key]['pictures'][$jey]['media']     = Storage::disk('public')->url($media->getMedia->path);
            }
        }

        return $arrayProducts;
    }

    public function getBanners()
    {
        return Banner::select([
                    'banners.id',
                    'banners.title',
                    'banners.link',
                    DB::raw('CONCAT("'. Storage::disk('public')->url('/') . '",media.thumbnail_path) AS thumbnail'),
                    DB::raw('CONCAT("'. Storage::disk('public')->url('/') . '",media.path) AS media'),
                ])
                ->join('media', 'banners.media_id', 'media.id')
                ->get();
    }

    public function getWeather()
    {
        $xmlResponse = simplexml_load_file('http://servicos.cptec.inpe.br/XML/cidade/2083/previsao.xml');
        $previsoes = [];

        for($i = 0; $i < 4; $i++){
            $previsoes[$i]['dia']       = date("d/m/Y", strtotime((string)$xmlResponse->previsao[$i]->dia));
            $previsoes[$i]['tempo']     = $this->getTempo((string)$xmlResponse->previsao[$i]->tempo)['title'];
            $previsoes[$i]['maxima']    = (string)$xmlResponse->previsao[$i]->maxima;
            $previsoes[$i]['minima']    = (string)$xmlResponse->previsao[$i]->minima;
            $previsoes[$i]['iuv']       = (string)$xmlResponse->previsao[$i]->iuv;
            $previsoes[$i]['img']       = "http://s0.cptec.inpe.br/webdop/static/resources/common/assets/images/icones/tempo/icones-grandes/".(string)$xmlResponse->previsao[$i]->tempo.".png";
        }

        return response()->json($previsoes);
    }

    private function getTempo($tempo)
    {
        $return = [];
        switch($tempo){
            case 'ec':
                $return['title'] = 'Encoberto com Chuvas Isoladas';
                break;
            case 'ci':
                $return['title'] = 'Chuvas Isoladas';
                break;
            case 'c':
                $return['title'] = 'Chuva';
                break;
            case 'in':
                $return['title'] = 'Instável';
                break;
            case 'pp':
                $return['title'] = 'Poss. de Pancadas de Chuva';
                break;
            case 'cm':
                $return['title'] = 'Chuva pela Manhã';
                break;
            case 'cn':
                $return['title'] = 'Chuva pela Noite';
                break;
            case 'pt':
                $return['title'] = 'Pancadas de Chuva a Tarde';
                break;
            case 'pm':
                $return['title'] = 'Pancadas de Chuva pela Manhã';
                break;
            case 'np':
                $return['title'] = 'Nublado e Pancadas de Chuva';
                break;
            case 'pc':
                $return['title'] = 'Pancadas de Chuva';
                break;
            case 'pn':
                $return['title'] = 'Parcialmente Nublado';
                break;
            case 'cv':
                $return['title'] = 'Chuvisco';
                break;
            case 'ch':
                $return['title'] = 'Chuvoso';
                break;
            case 't':
                $return['title'] = 'Tempestade';
                break;
            case 'ps':
                $return['title'] = 'Predomínio de Sol';
                break;
            case 'e':
                $return['title'] = 'Encoberto';
                break;
            case 'n':
                $return['title'] = 'Nublado';
                break;   
            case 'cl':
                $return['title'] = 'Céu Claro';
                break; 
            case 'nv':
                $return['title'] = 'Nevoeiro';
                break;
            case 'g':
                $return['title'] = 'Geada';
                break;
            case 'ne':
                $return['title'] = 'Neve';
                break;
            case 'pnt':
                $return['title'] = 'Pancadas de Chuva a Noite';
                break; 
            case 'psc':
                $return['title'] = 'Possibilidade de Chuva';
                break;  
            case 'pcm':
                $return['title'] = 'Possibilidade de Chuva pela Manhã';
                break; 
            case 'pct':
                $return['title'] = 'Possibilidade de Chuva pela Tarde';
                break; 
            case 'pcn':
                $return['title'] = 'Possibilidade de Chuva pela Noite';
                break; 
            case 'npt':
                $return['title'] = 'Nublado com Pancadas a Tarde';
                break; 
            case 'npn':
                $return['title'] = 'Nublado com Pancadas a Noite';
                break;
            case 'ncn':
                $return['title'] = 'Nublado com Poss. de Chuva a Noite';
                break; 
            case 'nct':
                $return['title'] = 'Nublado com Poss. de Chuva a Tarde';
                break; 
            case 'ncm':
                $return['title'] = 'Nublado com Poss. de Chuva pela Manhã';
                break; 
            case 'npm':
                $return['title'] = 'Nublado com Pancadas pela Manhã';
                break; 
            case 'npp':
                $return['title'] = 'Nublado com Possibilidades de Chuva';
                break; 
            case 'vn':
                $return['title'] = 'Variação de Nebulosidade';
                break; 
            case 'ct':
                $return['title'] = 'Chuva a Tarde';
                break; 
            case 'ppn':
                $return['title'] = 'Poss. de Panc. de Chuva a Noite';
                break; 
            case 'ppt':
                $return['title'] = 'Poss. de Panc. de Chuva a Tarde';
                break;
            case 'ppm':
                $return['title'] = 'Poss. de Panc. de Chuva a Manhã';
                break;
            default:
                $return['title'] = 'Não Definido';
                break; 
        }

        return $return;
    }

    public function getAnnouncements()
    {
        $userAccess = Auth::guard('api')->user();

        $products =  Product::where('person_id', $userAccess->getPerson->id)
                            ->orderBy('id', 'desc')
                            ->get();

        $arrayProducts = array();
        foreach($products as $key => $product){            
            $arrayProducts[$key]['id']              = $product->id;
            $arrayProducts[$key]['product_sub_category_id'] = $product->product_sub_category_id;
            $arrayProducts[$key]['name']            = $product->name;
            $arrayProducts[$key]['category']        = $product->getProductSubCategory->getProductCategory->category;
            $arrayProducts[$key]['subcategory']     = $product->getProductSubCategory->subcategory;
            $arrayProducts[$key]['price']           = $product->getPrice();
            $arrayProducts[$key]['content']         = $product->content;
            $arrayProducts[$key]['status']          = ($product->status == '1') ? "Ativo" : "Inativo";
            $arrayProducts[$key]['date_end']        = ($product->date_end != null) ? date('d/m/Y', \strtotime($product->date_end)) : "-";
            $arrayProducts[$key]['movie']           = ($product->getMedias()->whereHas('getMedia', function($query){
                                                            $query->where('media_type_id', 3);
                                                        })->first())?  Storage::disk('public')->url($product->getMedias()->whereHas('getMedia', function($query){
                                                            $query->where('media_type_id', 3);
                                                        })->first()->getMedia->path): NULL;

            $pictures = $product->getMedias()->whereHas('getMedia', function($query){
                        $query->where('media_type_id', 1);
                    })->get();

            $arrayProducts[$key]['pictures'] = array();
            foreach($pictures as $jey => $media){
                $arrayProducts[$key]['pictures'][$jey]['thumbnail'] = Storage::disk('public')->url($media->getMedia->thumbnail_path);
                $arrayProducts[$key]['pictures'][$jey]['media'] = Storage::disk('public')->url($media->getMedia->path);
            }
        }

        return $arrayProducts;

    }
}
