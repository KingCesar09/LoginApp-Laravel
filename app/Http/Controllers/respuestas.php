<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class respuestas extends Controller
{

    public  $response = [
        'status' => "ok",
        "result" => array()
    ];

// El método error_405 actualiza la clave status del arreglo $response a "error" y la clave result a otro arreglo asociativo con las claves 
// "error_id" y "error_msg". El valor de "error_id" es "405" y el de "error_msg" es "Metodo no permitido".
    public function error_405()
    {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "405",
            "error_msg" => "Metodo no permitido"
        );
        return $this->response;
    }

   // El método error_200 hace lo mismo que el método error_405, pero el valor por defecto de "error_id" es "200" y el valor de "error_msg" es el valor del parámetro $valor.
    public function error_200($valor = "Datos incorrectos")
    {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "200",
            "error_msg" => $valor
        );
        return $this->response;
    }

    //El método error_400 hace lo mismo que el método error_405, pero el valor por defecto de "error_id" es "400" y el valor de "error_msg" es "Datos incompletos o con formato incorrecto".
    public function error_400()
    {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "400",
            "error_msg" => "Datos incompletos o con formato incorrecto"
        );
        return $this->response;
    }

    //El método error_500 hace lo mismo que el método error_405, pero el valor por defecto de "error_id" es "500" y el valor de "error_msg" es el valor del parámetro $valor.
    public function error_500($valor = "Error interno del servidor")
    {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "500",
            "error_msg" => $valor
        );
        return $this->response;
    }

    //El método error_401 hace lo mismo que el método error_405, pero el valor por defecto de "error_id" es "401" y el valor de "error_msg" es el valor del parámetro $valor.
    public function error_401($valor = "No autorizado")
    {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "401",
            "error_msg" => $valor
        );
        return $this->response;
    }
}
