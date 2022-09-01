<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Media;
use App\MediaType;
use Route;
use Session;
use File;
use Illuminate\Http\UploadedFile;
use Storage;
use Image;
use Illuminate\Support\Facades\Hash;
use App\ProductHasMedia;

class MediaController extends Controller
{
    public function __construct()
    {
        // 
    }

    /**
     * Save files in storage and database Media
     * @param Illuminate\Http\UploadedFile
     * @param Int tamanho
     * @param int type_media of database
     * @return int media_id
     * @return string message_error
     * @return boolean save 
     */
    public function putMedia(UploadedFile $file, $size, $type)
    {        
        $arrayReturn = array();
        $arrayReturn['media_id'] = null;
        $arrayReturn['message_error']    = "";
        $arrayReturn['save'] = false;

        $typeMedia = MediaType::find($type);
        if($typeMedia == null)
        {
            $arrayReturn['message_error'] = "Type doesn't find.";
            return $arrayReturn;
        }        
        
        if($file->isValid())
        {            
            $explodeMimeType = explode("/", $file->getMimeType());
            if($explodeMimeType[0] == $typeMedia->type)
            {            
                if($file->getSize() < $size)
                {
                    if($typeMedia->type == 'image') {
                        // Save thumbnail
                        $thumb = Image::make($file)->fit(384, 216)->encode('jpg');
                        $hashThumb = md5($thumb->__toString());
                        $pathThumb = "pictures/{$hashThumb}.jpg";
                        $storageThumb = Storage::disk('public')->put($pathThumb, $thumb->__toString());
                    } else {
                        $pathThumb = null;
                    }

                    // Save file
                    $storage = Storage::disk('public')->putFile($typeMedia->path, $file);

                    $media = new Media(array(
                        'media_type_id'  => $typeMedia->id,
                        'media'          => $file->getClientOriginalName(),
                        'path'           => $storage,
                        'thumbnail_path' => $pathThumb
                    ));

                    $result = $media->save();
                    
                    if(!$result)
                    {
                        $arrayReturn['message_error'] = "Erro para inserir " . $typeMedia->type . " on database.";
                        return $arrayReturn;
                    }

                    $arrayReturn['media_id'] = $media->id;
                    $arrayReturn['save']     = true;
                    return $arrayReturn;
                }
                else
                {
                    $arrayReturn['message_error'] = "Você só pode inserir arquivos ". $typeMedia->files ." com até 2MB.";
                    return $arrayReturn;
                }
            }
            else
            {
                $arrayReturn['message_error'] = "Você só pode inserir arquivos ". $typeMedia->files ."";
                return $arrayReturn;
            }
        }
        else
        {
            $arrayReturn['message_error'] ="Sua " . $typeMedia->type . " não é valida.";
            return $arrayReturn;
        }        
    }

    /**
    * Delete Medias
    * @param int media_id
    * @return boolean
    */
    public function delMedia($mediaId)
    {        
        $media = Media::find($mediaId);
        if($media != null)
        {
            $result = $media->forceDelete();            
            if($result)
            {                
                $storage = Storage::disk('public')->delete($media->path);
                $storage = Storage::disk('public')->delete($media->thumbnail_path);
                if($storage)
                {
                    return true;
                }
                
            }            
        }

        return false;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $file = $request->file('file');
        if($file != null)
        {
            $resultMedia = $this->putMedia($file, $input['size'], $input['type']);
            if($resultMedia['save'])
            {
                $gallery = null;
                switch($input['table'])
                {
                    case 'product_has_media':
                        $gallery = new ProductHasMedia();
                        break;
                }

                if($gallery != null)
                {
                    $input['media_id'] = $resultMedia['media_id'];
                    $result = $gallery->fill($input)->save();                    
                }
            }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $media = Media::where('media', $id)->first();
       if($media == null) $media = Media::find($id);
       if($media != null)
       {
           if($this->delMedia($media->id))
           {
               return json_encode(true);
           }
       }
       return json_encode(false);
    }
}
