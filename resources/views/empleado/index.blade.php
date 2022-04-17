@extends('layouts.app')

@section('content')
<div class="container">

<!-- aqui validamos el hecho de que haya o no una session o variable llamada mensaje
 si lo hay, mandamos a mostrar este mensaje, recordemos que tenemos varios mensajes 
 que vienen enrutados junto a la ruta desde alguno de los metodos que usamos en el
 controlador, como empleado creado, eliminado o actualizado, entonces si vienen
 estos mensajes se ejecuta el codigo dentro del if, en este caso un boton ya hecho 
 en bootstrap
-->

    @if(Session::has('mensaje'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{Session::get('mensaje')}}

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"></span>
    </button>
    </div>
    @endif

<div class="row">
    <div class="col-xl-3">
     <a href="{{ url('empleado/create')}}" class="btn btn-success mb-4"> Registrar nuevo empleado</a>
    </div>

  

</div>


<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Foto</th>
            <th>Nombre</th>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>Correo</th>
            <th>Editar</th>
        </tr>
    </thead>
    <tbody>

    @foreach ( $empleados as $empleado )
        <tr>
            <td>{{ $empleado -> id}}</td>
            <td>
                <!--con lo que colocamos en el src, obtenemos el acceso a la ruta donde
                guardamos la foto del registro en particular que estamos visualizando 
            
                PARA QUE ESTO FUNCIONE TENEMOS QUE CREAR LA CONEXION CON EL 
                php artisan storage:link desde la terminal
                para eliminar este enlace usamos 
                cd public
                rm storage
                en caso tal de mover la carpeta, hay que borrar el enlace y volverlo a hacer
                -->
                <img class="img-thumbnail img-fluid" src="{{ asset('storage').'/'.$empleado->Foto}}" alt="" width="100">
            </td>
            <td>{{ $empleado -> Nombre}}</td>
            <td>{{ $empleado -> ApellidoPaterno}}</td>
            <td>{{ $empleado -> ApellidoMaterno}}</td>
            <td>{{ $empleado -> Correo}}</td>
            <td>
                <!-- para el edit, usamos lo mismo que en DELETE pero le agregamos con una concatenacion
                el  ./edit
                como lo indica el route:list -->
            <a href="{{ url('/empleado/'.$empleado->id.'/edit') }}" class="btn btn-danger">
                Editar
            </a> 
           
                 <!-- este formulario tiene un boton que me envia la informacion del id del usuario que 
             se desea borrar por medio del metodo POST y me lanza unu mensaje preguntando si deseamos
              borrarlo -->
            <form action="{{url('/empleado/'.$empleado->id)}}" class="d-inline" method="POST">
                @csrf
                <!-- el borrado se hace a travez del metodo destroy, pero con el metodo DELETE, o sea 
                qie el metofo POST lo usamos para enviar la info pero el DELETE la elimina-->
                {{ method_field('DELETE') }}
                <input class="btn btn-warning" type="submit" onclick="return confirm('¿Quieres Borrar?')" 
                value="Borrar">
            </form>
            </td>
        </tr>
    @endforeach
      
    </tbody>
</table>
{!! $empleados->links() !!}
</div>
@endsection

<!-- al final usamos {!! $empleados->links() !!} para paginar, esto usando la clase 
use Illuminate\Pagination\Paginator; en appserviiceprovider en providers dentro de http,
usamos el siguiente codigo instanciando la clase 
 public function boot()
    {
        //
        Paginator::useBootstrap();
    }
-->