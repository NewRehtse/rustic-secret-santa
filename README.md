# Amigo invisible rustico - Rustic Secret Santa

Se trata de un amigo invisible que hace un sorteo entre los participantes incluidos en el achivo particpants.json y envía el email correspondiente 
a cada a través del servidor SMTP configurado.

## Requisitos

- PHP 7.1
- Acceso a un servidor SMTP con el que enviar el email

## Utilización

1. Instalar dependencias
    
    ```bash
    composer install
    ```

2. Copiar `participants.dist.json` a `participants.json` y editarlo con los datos que sean necesarios.
    
    ```bash
    cp participants.dist.json participants.json
    ```

    Admite los siguientes campos: 
    * **details** *(obligatorio)*, detalles y condiciones que se quieran incluir.
    * **name** *(obligatorio)*, nombre que aparecerá en el correo.
    * **email** *(obligatorio)*, dirección de correo electrónico a la que llegará el resultado.
    * **address**, por motivos del covid igual este año no nos podemos dar el regalo presencialmente, he incluido la dirección para que la tengamos.
    * **suggestion**, alguna idea de regalo de esta  persona.

3. Copiar `.env.dist` a `.env` y editarlo con los datos del servidor smtp.

    ```bash
    cp .env.dist .env
    ```
    Yo por pereza he utilizado el smtp de una cuenta de gmail que tengo siguiendo estos pasos: https://phppot.com/php/send-email-in-php-using-gmail-smtp/
    Se trata de poner el usuario y contraseña de tu cuenta de gmail habiendo habilitado el acceso de aplicaciones no seguras en esa cuenta de correo, en esta url: https://myaccount.google.com/lesssecureapps
    *Tip: No useis vuestra cuenta principal para esto...*
    
    ```
    SMTP_SERVER=smtp.gmail.com
    SMTP_PORT=465
    SMTP_USERNAME=PUT_HERE_USERNAME
    SMTP_PASSWORD=PUT_HERE_PASSWORD
    ```

4. Modificar la plantilla *(Opcional)*
    Este es un paso opcional, en la plantilla hay dos etiquetas que se deben mantener, y dos opcionales:
    * DETAILS: detalles y condiciones que se quieran incluir.
    * FROM: Se trata el nombre del que va a regalar a algo.
    * NAME: El nombre de la persona que va a recibir el regalo.
    * ADDRESS: La dirección física de la persona que va a recibir el regalo.
    * SUGGESTION: Una idea de regalo que ha comunicado a quien lo organice para dar ideas.
    
    El resto de contenido HTML se puede modificar libremente.

5. Una vez configurado todo ejecutar santa.php.
    ```bash
    php run.php
    ```
    Esto realizará el sorteo, rellenará la plantilla y enviará el email.

## Licencia (MIT)

> **Copyright © 2015 Maël Nison**
>
> Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
>
> The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
>
> THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

