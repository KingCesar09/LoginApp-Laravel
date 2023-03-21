<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class authValidate extends Controller
{
    public function login($json)
    {
        $_respuestas = new respuestas; // Se crea una instancia de la clase 'respuestas'

        $datos = json_decode($json, true); // Decodifica el JSON recibido y lo convierte en un arreglo asociativo
        if (!isset($datos["correo"]) || !isset($datos["password"])) { // Verifica si se proporcionaron los datos necesarios
            return $_respuestas->error_401(); // Crea una respuesta de error 401 (No autorizado)
        } else {
            $correo = $datos["correo"];
            $password = $datos["password"];

            $_user = User::where('correo', $correo)->firstOrFail(); // Busca un usuario en la base de datos con el correo proporcionado
            $resultArray = array();

            foreach ($_user as $key) { // Convierte el objeto 'User' en un arreglo
                $resultArray[] = $key;
            }

            $datos = $this->convertirUtf8($resultArray); // Convierte todos los datos del arreglo a formato UTF-8

            if ($datos) { // Verifica si se encontró el usuario en la base de datos
                
                if (Hash::check($password, $_user["password"])) { // Verifica si la contraseña proporcionada coincide con la contraseña almacenada en la base de datos
                    $token = $_user->createToken('auth_token')->plainTextToken; // Crea un token de autenticación para el usuario
                    if ($token) {
                        $result = $_respuestas->response;

                        $result["result"] = array(
                            "token" => $token,
                            "id" => $_user["id"],
                            "nombre" => $_user["nombre"],
                            "rol" => $_user["rol"]
                        );

                        return $result; // Crea una respuesta con los datos del usuario y el token de autenticación
                    } else {
                        return $_respuestas->error_500("ERROR, no se guardo"); // Crea una respuesta de error 500 (Error interno del servidor)
                    }
                } else {
                    return $_respuestas->error_200("Contraseña invalida"); // Crea una respuesta de error 200 (Petición exitosa, pero con respuesta de error)
                }
            } else {
                return $_respuestas->error_200("El $correo no existe"); // Crea una respuesta de error 200 (Petición exitosa, pero con respuesta de error)
            }
        }
    }

    // Convierte todos los datos del arreglo a formato UTF-8
    public function convertirUtf8($array)
    {
        array_walk_recursive($array, function (&$item, $key) {
            if (!mb_detect_encoding($item, "utf-8", true)) {
                $item = iconv("ISO-8859-1", "UTF-8", $item);
            }
        });
        return $array;
    }
}
