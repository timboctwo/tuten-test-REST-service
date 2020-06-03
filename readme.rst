###################
Problema 2
###################

Por motivos tecnicos, se uso el Lenguaje PHP con ayuda del framework Codeingiter en un servidor Apache,

El servicio a consultar tiene el nombre de esta en la siguiente direccion: http://beta.timbocktu.com/tuten-test-REST-service/index.php/Api/dateFormat.

Es una llamada post, donde se debera de declarar el Header

	Content-Type : 'application/json'
	
Adicionalmente, se deben de agregar los siguientes parametros para enviar al servidor:

	{
	"hora": "15:23:12",
	"timezone": -5
	}

###################
Interpretacion del servicio
###################

De acuerdo con lo mencionado en el problema 2, se interpreto la creación del servicio de la siguiente manera:

el parametro *hora*, se encuentra en la zona horaria interpretada en el parametro *timezone* por lo cual, el servicio asigna la zona horaria a la hora determinada y esta se formatea a la zona horaria universal UTC
