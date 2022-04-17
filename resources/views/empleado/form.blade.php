    <h1>{{ $modo }} Empleado</h1>
    <!-- 
        ahora para validar los datos del formulario, despues de crear los objetos de campos requeridos
         y mensajes  de validacion, usaremos un if, que si encuentra errores(errors que es la variable
         donde se guardan estos errores validados), cualquiera que sea
          (en el objeto campos), los muestre recorriendolos por un foreach (aqui usamos el
          $erros->all() para traerlos todos), guardandolos en un alert
          y mostrandolos como lista
     -->
    @if (count($errors)>0)

        <div class="alert alert-success" role="alert">
            <ul> 
            @foreach ($errors->all() as $error)
                   <li> {{$error}} </li>
            @endforeach
            </ul> 
        </div>
        
    @endif

    <div class="form-group mb-3">
    <label for="Nombre"> Nombre</label>
    <input type="text" class="form-control" name="Nombre" value="{{ isset($empleado->Nombre)?$empleado->Nombre:old('Nombre') }}" id="Nombre">
    </div>

    <div class="form-group mb-3">
    <label for="ApellidoPaterno"> ApellidoPaterno</label>
    <input type="text" class="form-control" name="ApellidoPaterno" value="{{ isset($empleado->ApellidoPaterno)?$empleado->ApellidoPaterno:old('ApellidoPaterno')  }}" id="ApellidoPaterno">
    </div>

    <div class="form-group mb-3">
    <label for="ApellidoMaterno"> ApellidoMaterno</label>
    <input type="text" class="form-control" name="ApellidoMaterno" value="{{ isset($empleado->ApellidoMaterno)?$empleado->ApellidoMaterno:old('ApellidoMaterno') }}" id="ApellidoMaterno">
    </div>

    <div class="form-group mb-3">
    <label for="Correo"> Correo</label>
    <input type="text" class="form-control" name="Correo" value="{{ isset($empleado->Correo)?$empleado->Correo:old('Correo')  }}" id="Correo">
    </div>

    <div class="form-group mb-4">
    <label for="Foto"></label>
    @if (isset($empleado->Foto))
    <img class="img-thumbnail img-fluid mb-3" src="{{ asset('storage').'/'.$empleado->Foto }}" alt="" width="100">
    @endif
    <input type="file" class="form-control" name="Foto" value="" id="Foto">
    </div>

    <input class="btn btn-success" type="submit" value="{{ $modo }} Datos">

    <a  class="btn btn-primary" href="{{ url('empleado/')}}"> Regresar</a>

    

   

    <!-- como usamos el mismo form tanto para create como para edit, tendremos un error
   al ingresar al create porque en edit, pasamos el registro puntual del usuario que 
   editaremos, pero en create no, aqui no existe ni se envia, 
   entonces al mostrar el formuario en create, saltara error
   porque no tenemos este registro, esto hace parte de la forma en que lo hacemos, se soluciona
   validando si hay o no este registro con el isset($empleado->Correo)?$empleado->Correo:old('Correo')
   usamos el old('Correo') para que quede el dato anterior despues de que se detecte cualquier error y 
   se actualice la pagina
   -->