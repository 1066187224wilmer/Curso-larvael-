@extends('layout')

@section('title','homee')



@section('content')


<div class="container">
    <div class="row ">
      
        <div class="col-12 col-lg-6">
        <h1 class="display-4 text-primary">Desarrollo Web </h1>
        <p class="lead text-secondary">Lorem, ipsum dolor sit amet consectetur adipisicing elit.
              Architecto voluptate possimus esse omnis quia perferendis, eaque nihil, animi,
              reprehenderit corporis ullam autem iste voluptatum! Pariatur itaque aliquam odit
                 corporis aspernatur.</p>

                 <a class="btn btn-lg  btn-block btn-primary" 
                 href="{{route('contact')}}">
                 Contactame</a>


                 <a class="btn btn-lg  btn-block btn-outline-primary"
                   href="{{route('projects.idex')}}">Portafolio</a>
                
    </div>
    <div class="col-12 col-lg-6">
            <img class="img-fluid mb-4"src="/img/home.svg" alt="Desarrollo Web">
        </div>  
</div>
</div>


@endsection