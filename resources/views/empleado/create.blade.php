@extends('layouts.app')

@section('content')
<div class="container">

<form action="{{ url('/empleado')}}" method="POST" enctype="multipart/form-data">

    <!-- aqui usamos el @csrf para que el sistema sepa que este formulario esta viniendo
     del mismo sistema, esto lo hace con un token-->

     @csrf
   
     @include('empleado.form',['modo'=>'Crear'])

</form>

</div>
@endsection

<!-- ahora aprovecharemos el template que viene con la autentificacion
asi le daremos estilo a nuestras vistas por el momento -->