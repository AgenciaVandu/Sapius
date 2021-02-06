<?php

namespace App\Http\Controllers\Cursos;

use App\Models\Cursos\Media;
use App\Models\Cursos\Leccion;
use App\Models\Cursos\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Raju\Streamer\Helpers\VideoStream;

use App\Http\Controllers\Controller;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $leccion = Leccion::find($request->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        return view('medias.index')->with('leccion',$leccion)
                                    ->with('curso',$curso)
                                    ->with('modulo',$modulo)
                                    ->with('clase',$leccion);
    }

    public function getAll($leccion_id,$active)
    {
        if($active == "enable")
        $medias = Media::where('leccion_id',$leccion_id)->where('activo', 'si')->get();
        elseif($active == "disable")
        $medias = Media::where('leccion_id',$leccion_id)->where('activo', 'no')->get();
        return $medias->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $leccion = Leccion::find($request->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        $video = null;
        $video = Media::where('leccion_id',$request->leccion_id)
                        ->where('tipo',"=",'video')
                        ->where('activo',"=",'si')
                        ->first();
        $videoext = Media::where('leccion_id',$request->leccion_id)
                        ->where('tipo',"=",'videoext')
                        ->where('activo',"=",'si')
                        ->first();
        return view('medias.create')->with('leccion',$leccion)
                                     ->with('curso',$curso)
                                     ->with('modulo',$modulo)
                                     ->with('clase',$leccion)
                                     ->with('videoext',$videoext)
                                     ->with('video',$video);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $media = new Media();

        $media->leccion_id = $request->leccion_id;
        $media->tipo = $request->tipo;
        //depende de los casos
        if($media->tipo == "imagen"){
            $media->ruta = $this->imageUploadPost($request);
        }
        if($media->tipo == "archivo"){
            $media->ruta = $this->fileUploadPost($request);
        }
        if($media->tipo == "liga" || $media->tipo == "video" || $media->tipo == "videoext"){
            $media->ruta = $request->ruta;
        }
        $media->activo = "si";
        //\Log::debug(dd($media));
        $media->save();
        $leccion = Leccion::find($media->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        // return view('medias.index')->with('leccion',$leccion)
        //                             ->with('curso',$curso);
        return view('medias.index')->with('success', 'La media ha sido agregada correctamente')
                                                    ->with('leccion',$leccion)
                                                    ->with('curso',$curso)
                                                    ->with('modulo',$modulo)
                                                    ->with('clase',$leccion);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\media  $media
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $media = Media::find($id);
        return view('medias.show',compact('media'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $media = Media::find($request->id);
        $leccion = Leccion::find($media->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        return view('medias.edit')->with('media',$media)
                                     ->with('leccion',$leccion)
                                     ->with('curso',$curso)
                                     ->with('modulo',$modulo)
                                     ->with('clase',$leccion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $media = Media::find($request->id);

        $media->tipo = $request->tipo;
        //depende de los casos
        if($media->tipo == "imagen"){
            $media->ruta = $this->imageUploadPost($request);
        }
        if($media->tipo == "archivo"){
            $media->ruta = $this->fileUploadPost($request);
        }
        if($media->tipo == "liga" || $media->tipo == "video" || $media->tipo == "videoext"){
            $media->ruta = $request->ruta;
        }
        $media->activo = "si";
        //\Log::debug(dd($media));
        $media->save();

        $leccion = Leccion::find($media->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        // return view('medias.edit')->with('media',$media)
        //                              ->with('leccion',$leccion)
        //                              ->with('curso',$curso);
        $viewMultimedia = true;
        // return view('medias.index')->with('leccion',$leccion)
        //                             ->with('curso',$curso)
        //                             ->with('viewMultimedia',$viewMultimedia);
        $modulo = Leccion::find($leccion->leccion_id);
        return view('medias.index')->with('success', 'La media ha sido actualizada correctamente')
                                                    ->with('leccion',$leccion)
                                                    ->with('curso',$curso)
                                                    ->with('viewMultimedia',$viewMultimedia)
                                                    ->with('modulo',$modulo)
                                                    ->with('clase',$leccion);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $media = Media::find($request->id);
        $media->activo = "no";
        //\Log::debug(dd($leccion));
        $media->save();
        $leccion = Leccion::find($media->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        return view('medias.index')->with('leccion',$leccion)
                                    ->with('curso',$curso)
                                    ->with('modulo',$modulo)
                                    ->with('clase',$leccion);
    }

    public function activate(Request $request)
    {
        $media = Media::find($request->id);
        $media->activo = "si";
        //\Log::debug(dd($leccion));
        $media->save();
        $leccion = Leccion::find($media->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        return view('medias.index')->with('leccion',$leccion)
                                    ->with('curso',$curso)
                                    ->with('modulo',$modulo)
                                    ->with('clase',$leccion);
    }

    public function imageUploadPost(Request $request)
    {
        $file = $request->file('image');
        //\Log::debug(dd($file));
        if(is_null($file) || $request->imgEliminar == "si"){
            //\Log::debug(dd("file null"));
            return null;
        }
        // $request->validate([
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        // ]);
        $name = basename(Storage::put('images/medias', $file));
        return $name;
    }

    public function mediaPicture($file)
    {
        $storagePath = storage_path('app/images/medias/' . $file);
        return response()->file($storagePath);
    }

    public function fileUploadPost(Request $request)
    {
        $file = $request->file('file');
        //\Log::debug(dd($file));
        if(is_null($file) || $request->imgEliminar == "si"){
            //\Log::debug(dd("file null"));
            return null;
        }
        // $request->validate([
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        // ]);
        $name = basename(Storage::put('files/medias', $file));
        return $name;
    }

    public function stream($filename)
    {
        //$videosDir = config('larastreamer.basepath');
        $videosDir = storage_path('app/uploads/');
        if (file_exists($filePath = $videosDir."/".$filename)) {
            $stream = new VideoStream($filePath);
            return response()->stream(function() use ($stream) {
                $stream->start();
            });
        }
        //\Log::debug(dd($videosDir));
        return response("File doesn't exists", 404);
    }

    public function archivo($file)
    {
        $path = "files/medias/".$file;
        return Storage::download($path);
    }

}
