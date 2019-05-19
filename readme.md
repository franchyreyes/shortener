# Shortener

Es un proyecto tipo api creado para minificar las url largas. 

El algoritmo utilizado esta basado en generar una secuencia de caracteres entre 1 y 9 de longitud dependiendo del numero pasado como argumento a la funcion. Su retorno es un rango de letras del alfabeto desde A a la Z.

### Reseña del algoritmo

```
/**
* Converts an integer into the alphabet base (A-Z).
*
* @param int $number This is the number to convert.
* @return string 
* 
*/
    function generateKey($number)
    {
         /**
         * Create the size of the letters that can be generated 
         * where the number 26 represents (A-Z) of the alphabet
         */
        $size = 26;
        // this variable will store the generated result
        $result = '';
        // the number must be zero or greater
        for ($index = 1; $number >= 0 && $index < 10; $index++) {
            // this code below generates the character sequence and joined with previous one
            $result = chr(0x41 + ($number % pow($size, $index) / pow($size, $index - 1))) . $result;
            // Reduce the number with the size of the array raised to the iteration
            $number -= pow($size, $index);
        }
        return $result;
    }

```

### Utilizar el algoritmo

Solo se necesita llamar la funcion, ya que fue cargada en el archivo composer.json mediante autoload

```
generateKey(50); #return 'AY'
generateKey(20); #return 'U'
generateKey(30); #return 'AE'
```
## Configurando el proyecto

1- Clonar el repositorio del proyecto

```
git clone https://github.com/franchyreyes/shortener.git
cd shortener
```
2- Crear el archivo .env de nuestra aplicacion shortener

```
cp .env.example .env
```

3 - Colocar las informacion de las base de datos en el nuevo archivo .env 
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shortener
DB_USERNAME=root
DB_PASSWORD=
```

## Instalación de Laravel Homestead

1 - [Descarga VirtualBox](https://www.virtualbox.org/wiki/Downloads): el archivo a descargar varía dependiendo del sistema operativo

2 - [Descarga Vagrant](https://www.vagrantup.com/downloads.html): de nuevo el archivo a descargar depende del sistema operativo 

3 - Instala VirtualBox: siguiendo los pasos del instalador

4 - Instala Vagrant: siguiendo los pasos del instalador

5 - Agrega el Box de Laravel Homestead con el siguiente comando en la terminal: 
```
vagrant box add laravel/homestead
```

6 - Comprueba que ha sido instalado con éxito con vagrant box list 
```
vagrant box list
```
7 - Clonar Laravel Homestead
```
git clone https://github.com/laravel/homestead.git proyectos
```
8 - Debería revisar una versión etiquetada de Homestead, ya que es posible que la rama maestra(master) no siempre sea estable. Puede encontrar la última versión estable en el [Versiones de Homestead en Github](https://github.com/laravel/homestead/releases)
```
cd ~/Homestead

// Clonar la version mas estable
git checkout v8.4.0
``` 
10 - Accede al directorio donde instalaste Homestead, ahi dentro se encuentra el archivo init.sh or init.bat 

```
cd ~/Homestead
``` 
11 - Ahora ejecuta el comando mostrado debajo para que se cree el archivo de configuración Homestead.yaml 
```
 // Mac / Linux...
bash init.sh

// Windows...
init.bat
```
12 - Abrir archivo (Homestead.yaml) en el editor de tu preferencia

En un principio necesitamos tocar pocas cosas del Homestead.yaml, porque la mayoría ya se ha configurado automáticamente, acorde con nuestro sistema operativo gracias al archivo init.sh o init.bat, pero podrás desear cambiar los siguientes campos:

* IP del servidor virtual, por defecto aparece ip: "192.168.10.10". 
    Llave para la conexión SSH con la máquina virtual (ver información más abajo) 
* Folders, que son las carpetas que vas a tener en tu sitio, mapeadas en     dos direcciones, el servidor virtual y el ordenador local (luego te        decimos cómo). 
* Sites, para definir el nombre del sitio para el virtualhost.

## Configuración de Laravel Homestead

1 - Abrir el Bash de Git

2 - Esta es la llave para la conexión con el servidor virtual por línea de comandos. Desde Windows la recomendación es usar el "Bash de Git"

```
ssh-keygen -t rsa -C "you@homestead"
```
3 - El lugar donde vas a tener que introducir la ruta de la clave será algo como esto dentro del archivo Homestead.yaml:

```
authorize: ~/.ssh/id_rsa.pub

keys:
    - ~/.ssh/id_rsa
```

4 - Ahora en el archivo Homestead.yaml tendrás que definir esa estructura de carpetas, que se adaptará a tus costumbres habituales.Como hemos comentado antes, tendrás una carpeta de tu ordenador donde guardas tus proyectos y seguirá siendo así. Por tanto, es simplemente guardar este proyecto en una carpeta en una ruta habitual para ti.

```
// "map" ruta de la carpeta de maquina local donde
// "to"  la ruta de la carpeta del ordenador virtualizado

folders:
    - map: ~/proyectos/Homestead/code
      to: /home/vagrant/code
```
5 - Configurar el nombre del host virtual que nos va a configurar Homestead en esta máquina virtual 

```
// "map" colocamos el nombre de dominio para el virtualhost
// "to" indicamos la carpeta del servidor virtual

    sites:
    - map: shortener.app
      to: /home/vagrant/code/shortener/public
```
6 - Luego de los detalles descrito anteriormenete como [app, servidor web, y base de datos] podemos copiar y pegar. Resultado Final del (Homestead.yaml)  

```
 ---
ip: "192.168.10.50"
memory: 2048
cpus: 1
provider: virtualbox

authorize: ~/proyectos/Homestead/keyrsa.pub

keys:
    - ~/proyectos/Homestead/keyrsa

folders:
    - map: ~/proyectos/Homestead/code
      to: /home/vagrant/code

sites:
    - map: shortener.app
      to: /home/vagrant/code/shortener/public

databases:
    - shortener

# ports:
#     - send: 50000
#       to: 5000
#     - send: 7777
#       to: 777
#       protocol: udp

# blackfire:
#     - id: foo
#       token: bar
#       client-id: foo
#       client-token: bar

# zray:
#  If you've already freely registered Z-Ray, you can place the token here.
#     - email: foo@bar.com
#       token: foo
#  Don't forget to ensure that you have 'zray: "true"' for your site.

```

7 - Crea un Virtual Host modificando el archivo /etc/hosts, de nuevo utilizando el editor de tu preferencia. Es posible que necesites utilizar sudo para editar el archivo, por ejemplo: sudo nano /etc/hosts luego agrega la IP y el dominio en una nueva línea.

```
    //ruta en window: C:\Windows\System32\drivers\etc
    192.168.10.50 shortener.app
```
### Iniciar la máquina virtual

1 - Vamos al directorio donde instalamos Homestead

```
cd ~/Homestead
```
2 - Una vez configurado el Homestead.yaml tienes que lanzar la máquina virtual, es decir, tendrás que ponerla en marcha, con el conocido comando de Vagrant:

```
vagrant up
```

3 - Una vez lanzada la máquina virtual podríamos hacer una primera prueba accediendo a la IP del servidor virtual con tu navegador
```
http://192.168.10.50/
```

### Conectándonos a nuestra máquina virtual con SSH

1- Vamos nuevamente al directorio Homestead

```
cd ~/Homestead
```
2 - Ejecutamos el comando 

```
vagrant ssh
```

### Configurando Base de datos y Composer

1- Vamos a la carpeta donde esta nuestro proyecto en la maquina virtual

```
cd code
cd shortener
```
2 - Instalar las dependecias del proyecto

```
composer install
```
3 - Generar permisos y claves para MYSQL
```
//colocar clave por defecto:  "secret"
mysql -u root -p
```
4 - Instalar las migraciones

```
php artisan migrate
```

## Como utilizar el API

Desde desde un cliente de endpoint como ejemplo POSTMAN o usando la libreria CURL y por ultimo usando una petición HTTP podes usar las siguientes rutas segun el nombre de dominio establecido en el servidor.

http://dominio/api/link utilizando el metodo POST y recibiendo una peticion con  la variable url la cual va a contener la url que pasara por el proceso de minificacion.

En caso de tengamos un error porque la url no cumple con los parametros adecuados entonces

```
{
    "errors" => {
        'url' => ' invalid URL ',
    }
}
```

Para las respuestas positivas el API retornara un JSON con la siguiente estructura:

```
{
    "url": {
        "generated": "http://<dominio>/C",
        "original": "https://www.youtube.com/",
        "key": "C"
    }
}
```
## Utilizar la url minificada

Debe utilzar un navegador y una de las urls generadas previamente

```
http://dominio/key
```
En caso de no encontrar la url o key de busqueda nos devolvera un JSON con el siguiente formato

```
{
    "error": "Not Found resource"
}
```


## Obtener el TOP de los 100 mas visitados

Usamos el http://dominio/api/link/top mediante el metodo GET, devolviendo una colección de datos de los links más accesadas ordenados de mayor a menor segun sus visitas.

```
{
    "links": [
        {
            "key": "E",
            "url": "https://www.facebook.com/",
            "total_views": 2
        },
        {
            "key": "B",
            "url": "https://www.youtube.com/",
            "total_views": 1
        },
        {
            "key": "C",
            "url": "https://outlook.live.com/owa/",
            "total_views": 0
        }        
    ]
}
```

## License
Este proyecto esta bajo la licenia de MIT [LICENSE](https://opensource.org/licenses/MIT) 

