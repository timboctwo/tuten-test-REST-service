<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* Ejemplo del uso de una clase DAO, si es que se obtuvieran los datos de una base de datos */
class DatetimeDAO extends CI_Model{
	function __construct(){
        parent::__construct();
    }

    /* Crea un DateTime dependiendo de la variacion de horas indicada en '$timezone' */
    function getConvertedUTCHour($hora, $timezone, $format){
        //Zona horaria recibida
        $dateTime = DateTime::createFromFormat($format, $hora, new DateTimeZone($timezone.'00'));
        //Zona horaria Universal (UTC)
        $dateTime->setTimezone(new DateTimeZone("UTC"));
        return $dateTime->format($format);
    }
}