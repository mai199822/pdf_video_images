<?php

namespace App\Http\Controllers;


use App\Models\Form;
use Carbon\Carbon;
use Lakshmaji\Thumbnail\Facade\Thumbnail;

use ConvertApi\ConvertApi;
use Illuminate\Http\Request;


class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
       
        $forms = Form::get();


        return view('show', [
            'forms' => $forms,
        ]);

    
    }


    public function create()
    {
        //
        return view('form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //


        $form = Form::create($request->except([
            'file', 'video', 'file_thumb', 'video_thumb'
        ]));

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $path = $file->store('files', 'public');
            $path_to_save = public_path("storage/extr_img");
            ConvertApi::setApiSecret('yrOws1JZZ40ZKCqn');
            $result = ConvertApi::convert(
                'extract-images',
                [
                    'File' => public_path("storage/" . $path),
                ]
            );


            $result->getFile()->save($path_to_save);
            $img_path = "extr_img/" . $result->getFile()->getFileName();

            $form->update([
                'file' => $path,
                'file_thumb' => $img_path,
            ]);
            /*$response = Http::post('https://v2.convertapi.com/convert/pdf/to/extract-images?Secret=yrOws1JZZ40ZKCqn&StoreFile=true',[
                "File" => $file,
                "Parameters"=> [
                    [
                        "Name" => "File",
                        "FileValue" => [
                            "Name" => "test.pdf",
                            "Data" => "<Base64 encoded file content>"
                        ]
                    ],
                    [
                        "Name" => "StoreFile",
                        "Value" => true
                    ]
                ]
            ]);*/
        }
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $path = $file->store('videos', 'public');

            $name  = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString()).'.jpg';
            dd($name);

            $videoUrl = public_path('storage/' .$path);
            //http://localhost:8000/storage/videos/NMkraItHMfyr5AiUzSIIRn0SVdG6EVl3Og0auKA3.mp4
            $path_to_save = public_path('storage/thumbnail');
            
            $thumbnail_status = Thumbnail::getThumbnail($videoUrl, $path_to_save, $name,0);
            
            $vedio_path = 'thumbnail'.$name;


            


            $form->update([
                'video' => $path,
                'video_thumb' => $vedio_path,
            ]);
        }

        return redirect()->route('forms.index');
    }
}
