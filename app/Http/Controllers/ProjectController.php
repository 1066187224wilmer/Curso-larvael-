<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Project;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SaveProjectRequest;



class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index','show');/*el metodo aud bloquea todo exepto index y show*/
        /* asi se protege el metodo que quieras*/

    } 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $projects = Project::latest()->paginate();                /* $portafolio = DB::table('projects')->get();se lla el metodo get para obtener toodo los datos */
                                                                                 /* $portafolio = Project::orderby('created_at','DESC')->get(); */
        return view('projects.index',compact('projects')); 
                                                             /* <small>{{$portafolioItem->description}}</small><br>
                                                                                  <small>{{$portafolioItem->created_at->format('d-m-y')}}</small> */
    }                                                                             

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create',[
            'project'=>new Project
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveProjectRequest $request)
    {  
        
    $project = new Project($request->validated());   


    $project->image = $request->file('image')->store('images');


    $project->save();



    return redirect()->route('projects.idex')->with('status','El proyecto fue creado con exito'); 
/* 
        $fields = request()->validate([
             'title'=>'required',
             'url'=>'required',
             'description'=>'required', 
        ]); */
        
        
       /*  Project::create(request()->only('title','url','description')); */
       /*  Project::create(request()->all()); */
        /* ([
            'title'=>request('title'),
            'url'=>request('url'),
            'description'=>request('description'),

        ]); */
   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
      
       return view('projects.show',compact('project'));
       
       
       /* ['project' => $project]);  */
    }    /* route-model-binding */

   /*  public function show($id)
    {
       $projects =Project::findOrFail($id);
       return view('projects.show',compact('projects')); //
    } */




    /**
     * 
     * 
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
    return view('projects.edit',compact('project'));
        }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Project $project, SaveProjectRequest $request)
    {

        if($request->hasfile('image')){//si el request contiene el archivo con el nombre 'image'
         
        Storage::delete($project->image);


        $project->fill($request->validated());//se vlida 

         $project->image = $request->file('image')->store('images');//asignamos imagen que se sube
               

        $project->save();//se guarda


        $image=Image::make(storage::get($project->image))
       ->widen(600)
       ->LimitColors(255)
       ->encode();
            
        Storage::put($project->image, (string) $image);

        }else{
            
            $project->update(array_filter($request->validated()));//array_filter para que se actualice los datos y la imagen se mantega
        }


        return redirect()->route('projects.show',$project)->with('status','El proyecto fue Actualizado con exito'); 
    }

    /**
     * Remove the specifi,ed resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        Storage::delete($project->image);//para eliminar imagen del servidor pero no esta acyualmente eliminando 

        $project->delete();
        return redirect()->route('projects.idex')->with('status','El proyecto fue Eliminado con exito');
        //Project::destroy($id);
    }
}
