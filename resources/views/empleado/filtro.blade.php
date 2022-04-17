@extends('layouts.app')

@section('content')
<div class="container">


<div class="row">
    <div class="col-xl-3">
     <a href="{{ url('empleado/create')}}" class="btn btn-success mb-4"> Registrar nuevo empleado</a>
    </div>

    <div class="col-xl-6">
        <form action="/empleadoBuscado" metho="GET">
            <div class="row" >
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="nombre_empleado">
                </div>
                <div class="col-auto">
                    <input type="submit" value="Buscar" class="btn btn-primary">
                </div>
            </div>
        </form>
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

    @foreach ( $empleadoBuscado as $empleado )
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
</div>
@endsection
