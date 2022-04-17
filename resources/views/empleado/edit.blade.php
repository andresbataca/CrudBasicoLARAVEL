@extends('layouts.app')

@section('content')
<div class="container">

<form action="{{url('/empleado/'.$empleado->id)}}" method="post" enctype="multipart/form-data">
@csrf
{{ method_field('PATCH') }}
    
@include('empleado.form',['modo'=>'Editar'])

</form>

</div>
@endsection

<!-- como compartimos formulario con edit y create, y por ejemplo en el boton para enviar datos
usamos editar o crear datos, no se pueden repetir y tiene que ser especifico pra cada uno, para lograr esto
usamos el 'modo' que sera como una varible que guardara la palabra exacta que usaremos dependiendo 
del formulario, en el template solo colocaremos $modo  y mostrara la palabra que se 
necesita dependiendo de la vista que llame el form -->
