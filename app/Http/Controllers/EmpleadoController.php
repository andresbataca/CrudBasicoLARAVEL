<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;


/*esta clase la agregamos para poder eliminar la imagen */
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*por que usamos el 'empleados' dentro de la variable? porque de esta forma 
        llamaremos nuestra tabla dentro del htnl de la vista*/
        $datos['empleados'] = Empleado::paginate(3);
        return view('empleado.index',$datos);
    }

    public function filter (Request $request){
        
        $nombreEmpleado = $request->get('nombre_empleado');

        $empleadoBuscado = \DB::connection('mysql')
        ->table('empleados')
        ->where('Nombre','LIKE','%'.$nombreEmpleado.'%')
        ->orWhere('ApellidoPaterno','LIKE','%'.$nombreEmpleado.'%')
        ->orWhere('ApellidoMaterno','LIKE','%'.$nombreEmpleado.'%')
        ->get();

        //dd($empleadoBuscado);
        return view('empleado.filtro',['empleadoBuscado'=>$empleadoBuscado]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     /* la informacion que se recibe muestra aqui en el formulario de create
     se guarda en el store, para saber como enviar, tenemos que saber que tipo de envio usa 
     el metodo, en este caso el store, usa el POST, esto lo vemos cn  php artisan route:list */
    public function create()
    {
        //
        return view('empleado.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$datosEmpleado = request()->all();

        /*ahora validaremos los campos, para evitar errores, creando dos objetos
        que guarden datos para validar*/

        $campos=[
            'Nombre'=>'required|string|max:100',
            'ApellidoPaterno'=>'required|string|max:100',
            'ApellidoMaterno'=>'required|string|max:100',
            'Correo'=>'required|email',
            'Foto'=>'required|max:10000|mimes:jepg,png,jpg'
        ];

        $mensaje=[
            'required'=>'El :attribute es requerido',
            'Foto.requerid'=>'la foto es requerida'
        ];

        /*despues de tener los campos que vamos a validar y los mensajes, validamos
        con un $this->validate($request,$campos,$mensaje);
        le decimos que lo que enviaamos eñ request, sea validado con campos, y muestre 
        el respectivo mensaje, estos mensajes se mostraran en la vista
        */
        $this->validate($request,$campos,$mensaje);


        $datosEmpleado = $request->except('_token');

        if ($request->hasFile('Foto')) {
            $datosEmpleado['Foto']=$request->file('Foto')->store('uploads','public');
        }
        Empleado::insert($datosEmpleado);

        //return response()->json($datosEmpleado);

        /*ahora retornaremos hacia la redireccion y esto sera hacia el empleado, o sea al index
        e ira con un mensaje  */
        return redirect('empleado')->with('mensaje','Empleado agregado con Exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /*La variable empleado, sera igual a nuestro modelo o tabla, buscando los datos con FINORFAIL 
        del id que se envia por parametro desde nuestro template html
        tambien tendremos que pasarle esta informacion al formulario para 
        que se muestre, esto lo hacemos con el compact('empleado')
        retornamos con el return, a la vista del empleado.edit, pero con los datos de que necesitamos
        todos los datos del campo con su id
        */
        $empleado=Empleado::findOrFail($id);
        return view ('empleado.edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        /*aqui validaremos de la misma forma que en el store, pero con ciertos cambios,
        por ejemplo, al no haber ingresado nada en imagen, siempre nos saltara el error de que falta 
        la imagen, por eso tendremos que validar que si existe la foto, ahi si mande el mensaje,
        esto para que en caso tal de no hacer ningun cambio, no nos salte el error  */
        $campos=[
            'Nombre'=>'required|string|max:100',
            'ApellidoPaterno'=>'required|string|max:100',
            'ApellidoMaterno'=>'required|string|max:100',
            'Correo'=>'required|email'
            
        ];

        $mensaje=[
            'required'=>'El :attribute es requerido',
        ];

        if ($request->hasFile('Foto')) {
            $campos=[
            'Foto'=>'required|max:10000|mimes:jepg,png,jpg'
            ];
            $mensaje=[
                'Foto.requerid'=>'la foto es requerida'
            ];
        }

        $this->validate($request,$campos,$mensaje);

        //aqui quitamos el token y el metodo PACH para que solo tengamos los datos que necesitamos al actualizar
        $datosEmpleado = $request->except('_token','_method');
        
        if ($request->hasFile('Foto')) {

            /*aqui lo que haremos es preguntar si hay algun archivo, 
            si lo hay entramos al if y buscamos los datos de la tabla con respecto al id
            que ingresamos, despues con la clase usada arriba borramos del storage la foto
            del id del usuario, despues le decimos que la foto nueva que ingresa
            se guarde en el stororage nuevamente */
            $empleado=Empleado::findOrFail($id);
            Storage::delete('public/'.$empleado->Foto);
            $datosEmpleado['Foto']=$request->file('Foto')->store('uploads','public');
        }
        
        /*aqui lo que haceremos es tomar nuestra tabl empleado y le decimos que cuando el id de la tabla
        sea igual al id que viene por parametros, actualice los desmas campos */
        Empleado::where('id','=',$id)->update($datosEmpleado);

        /*despues volvemos a buscar la informacion ya actualizada, de acuerdo al id y retorno al 
        formulario pero con los datos actualizados */

        $empleado=Empleado::findOrFail($id);
        //return view ('empleado.edit', compact('empleado'));

        return redirect('empleado')->with('mensaje','Empleado Actualizado');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /*aca recibimos el id exacto del campo que queremos borrar para quesea destruido
         pero antes, tendremos que borrar de la carpeta storage la foto correspondiente al id
         esto lo hacemos con un if, que borra y pregunta si ya se borro, para ahi si, proceder a borrar
         los demas datos
        y retornamos con el return a nuestra index empleado, recordemos que el index es la pantalla
         principal*/

        $empleado=Empleado::findOrFail($id);  
        if (Storage::delete('public/'.$empleado->Foto)){
            Empleado::destroy($id);
        }
      
        return redirect('empleado')->with('mensaje','Empleado borrado');
    }
}

/*recordemos que al decir redirect('empleado'), en realidad estamos mandando la ruta 
al .index */