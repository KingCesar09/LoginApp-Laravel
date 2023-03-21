<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\respuestas; // Se importa el controlador 'respuestas'
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        $_respuestas = new respuestas; // Se crea una instancia de la clase 'respuestas'
        $_authVali = new authValidate; // Se crea una instancia de la clase 'authValidate'

        if ($_SERVER["REQUEST_METHOD"] == "POST") { // Verifica si la solicitud HTTP es de tipo POST
            // Recibe datos enviados
            $postBody = file_get_contents("php://input");
            // Envía los datos al manejador de validación
            $datosArray = $_authVali->login($postBody);
            // Devuelve respuesta
            header("Content-Type: application/json"); // Establece el tipo de respuesta como JSON
            if (isset($datosArray["result"]["error_id"])) { // Verifica si se produjo un error al procesar los datos
                $responseCode = $datosArray["result"]["error_id"]; // Obtiene el código de error
                http_response_code($responseCode); // Establece el código de respuesta HTTP como el código de error
            } else {
                http_response_code(200); // Si no hubo errores, establece el código de respuesta HTTP como 200 (OK)
            }
            echo json_encode($datosArray); // Devuelve la respuesta como JSON

        } else {
            $_respuestas = new respuestas;
            header("Content-Type: application/json"); // Establece el tipo de respuesta como JSON
            $datosArray = $_respuestas->error_405(); // Crea una respuesta de error 405 (Método no permitido)
            echo json_encode($datosArray); // Devuelve la respuesta de error como JSON
        }
    }
}
