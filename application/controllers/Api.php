<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Api extends REST_Controller {


    function __construct(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        parent::__construct();
        $this->load->model('DatetimeDAO');
    }

    function dateFormat_post(){

        $formato = "H:i:s";
        $jsonArray = json_decode($this->input->raw_input_stream, true);

        /* Valida que se envien los parametros "hora" y "timezone" */
        if(array_key_exists('timezone', $jsonArray) && array_key_exists('hora', $jsonArray)){
            $hora = $jsonArray['hora'];
            $timezone = $jsonArray['timezone'];
            $dataArray = new stdClass();
            if(is_String($hora)){
                if(!is_int($timezone)){
                    /* Se rompe el flujo si la variable 'timezone' no es un numero */
                    $status = "error";
                    $message = "El parametro 'timezone' debe ser un valor numerico,";
                    $response = array(
                        "status" => $status,
                        "message" => $message
                    );
                    $this->response($response,REST_Controller::HTTP_OK);
                    exit();
                }
                /* Valida que el formato de 'hora' sea el correcto */
                if(DateTime::createFromFormat($formato, $hora) !== FALSE){
                    $dateSplited = explode(":", $hora);
                    /* Valida que sea una hora valida */
                    if((int)$dateSplited[0] >= 24 || (int)$dateSplited[1] >= 60 || (int)$dateSplited[0] >= 60){
                        $status = "error";
                        $message = "Formato de fecha invalido, usar un valor real (menor a 24:00:00)";
                    }else{
                        /* Se realiza la conversion de zona horaria */
                        $fecha = $this->DatetimeDAO->getConvertedUTCHour($hora, $timezone, $formato);
                        $dataArray->time = $fecha;
                        $dataArray->timezone = "UTC";
                        $status = "success";
                        $message = "Exito en el cambio de Zona horaria";
                    }
                }else{
                    $status = "error";
                    $message = "Formato de fecha invalido, usar HH:mm:ss";
                }
            }else{
                $status = "error";
                $message = "El parametro 'hora' debe ser un String,";
            }
        }else{
            $status = "error";
            $msg = "faltan uno o mas parametros requeridos";
        }
        /* Recopilacion de los datos para crear el JSON */
        $response = new stdClass();
        $response->status=$status;
        $response->message=$message;
        $response->response=$dataArray;
        /* Se crea el JSON en vase a la variable '$response' y se envia una respuesta exitosa (200) */
        $this->response($response,REST_Controller::HTTP_OK);
    }

}

?>