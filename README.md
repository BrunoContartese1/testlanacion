<h1>Aplicación de test RR HH La Nación.</h1>
Esta aplicación fue creada con el fin de cumplir con el ejercicio de programación requerido por el departamento de RR. HH del grupo La Nación. 
La aplicación consiste en implementar en PHP utilizando el framework LARAVEL los endpoints necesarios para realizar un ABM de sensores, los cuáles tienen una posición en un plano en R2 (una mesa). Cada punto por ende, tendrá una coordenada (x;y).
También se pide obtener los puntos más cercanos a otro.

No se dieron pautas de diseño.

En esta aplicación utilice el framework laravel como fue requerido, utilizando VUE para el front end, y laravel passport para la autenticación de la API. También se utilizaron varios paquetes no relevantes.

<h2>Inicialización del proyecto</h2>

Descargar los archivos del repositorio o correr el siguiente comando

> git clone https://github.com/BrunoContartese1/testlanacion.git

Copiar el archivo .env.example y modificarlo con los datos de acceso a la base de datos.

Correr los siguientes comandos
> composer install
> npm install
> npm run prod

Una vez hecho los pasos anteriores correr el siguiente comando
> php artisan migrate --seed

Luego

>php artisan passport:install

Este último comando nos dará la key para poder configurar Laravel passport y poder asi autenticarnos en la API.
Se debe copiar el CLIENT SECRET del CLIENT ID Nº 2 (password grant client) en el archivo .env en la lnea que dice "PASSPORT_CLIENT_SECRET"

La línea debera quedar algo parecido a <b>PASSPORT_CLIENT_SECRET=ivcwDbdVmhD6CFHQ7SgOZSL4D2DXbFdTebkjpp9E</b>

Una vez realizados estos pasos debera poder entrar a la aplicación logueandose con el usuario y contraseña por defecto que es
> Usuario: demo    Contraseña: demo
