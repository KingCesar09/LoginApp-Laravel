<?php

namespace App\Http\Controllers; //namespace que define el controlador

use Illuminate\Http\Request; //importa la clase Request desde el framework Laravel
use App\Http\Controllers\respuestas; //importa la clase respuestas creada en el mismo namespace
use App\Models\User; //importa el modelo User
use Illuminate\Support\Facades\Hash; //importa la clase Hash para encriptar contraseñas

class userValidate extends Controller //crea la clase userValidate que extiende de la clase Controller
{
    private $usuarioId = ""; //declara variable privada
    private $nombre = ""; //declara variable privada
    private $rol = ""; //declara variable privada
    private $correo = ""; //declara variable privada
    private $password = ""; //declara variable privada

    public function post($json)
    {
        $_respuestas = new respuestas;
        $_user = new User;
        $datos = json_decode($json, true);

        if (!isset($datos["nombre"]) || !isset($datos["rol"]) || !isset($datos["correo"]) || !isset($datos["password"])) {
            return $_respuestas->error_400();
        } else {
            $this->nombre = $datos["nombre"];
            $this->rol = $datos["rol"];
            $this->correo = $datos["correo"];
            $this->password = $datos["password"];

            $_user->nombre = $this->nombre;
            $_user->rol = $this->rol;
            $_user->correo = $this->correo;
            $_user->password = Hash::make($this->password);
            $_user->save();
            $respu = $_user;
            if ($respu["id"]) {
                $resp = $respu["id"];
            } else {
                $resp = 0;
            }

            if ($resp != null) {
                $resp = $resp;
            } else {
                $resp = 0;
            }

            if ($resp != null) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id" => $resp
                );
                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }


    public function patch($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if (!isset($datos["id"])) {
            return $_respuestas->error_400();
        } else {
            $this->usuarioId = $datos["id"];

            if (isset($datos["nombre"])) {
                $this->nombre = $datos["nombre"];
            }
            if (isset($datos["correo"])) {
                $this->correo = $datos["correo"];
            }
            if (isset($datos["password"])) {
                $this->password = $datos["password"];
            }
            if (isset($datos["rol"])) {
                $this->rol = $datos["rol"];
            }

            $_user = User::find($this->usuarioId);
            $resultArray = array();

            foreach ($_user as $key) {
                $resultArray[] = $key;
            }
            $datos = $this->convertirUtf8($resultArray);

            if ($datos) {
                $_user->nombre = $this->nombre;
                $_user->rol = $this->rol;
                $_user->correo = $this->correo;
                $_user->password = Hash::make($this->password);
                $_user->save();
                $respu = $_user;
                if ($respu) {
                    $resp = $respu;
                } else {
                    $resp = 0;
                }

                if ($resp) {
                    $respuesta = $_respuestas->response;
                    $respuesta["result"] = array(
                        "id" => $this->usuarioId
                    );
                    return $respuesta;
                } else {
                    return $_respuestas->error_500();
                }
            } else {
                return $_respuestas->error_200("Usuario inactivo!!");
            }
        }
    }


   
    public function delete($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if (!isset($datos["id"])) {
            return $_respuestas->error_400();
        } else {
            $this->usuarioId = $datos["id"];

            $_user = User::find($this->usuarioId);
            $_user->delete();

            $respuesta = $_respuestas->response;
            $respuesta["result"] = array(
                "id" => $this->usuarioId
            );
            return $respuesta;
        }
    }


  
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
