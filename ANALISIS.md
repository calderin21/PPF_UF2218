#### index.php
Punto de entrada a la aplicación web de gestión de coches.
Ofrece la vista de los datos de coches en una tabla; cada fila contiene un botón para eliminar el coche correspondiente.
Se incluye además un formulario para insertar datos de un nuevo coche.
Se comunica con los controladores PHP para ejecutar las acciones disparadas.

#### insertar_coche.php
Controlador para insertar un nuevo nodo de coche en `files/coches.xml`.
Se dispara al enviar el formulario de inserción de coche en `index.php`.

#### eliminar_coche.php
Controlador para eliminar un nodo de coche existente de `files/coches.xml`.

#### files/coches.xml
Colección de datos de coches en formato XML.

#### files/coches.xsd
Esquema para validar la estructura de `files/coches.xml`.
Usado por `insertar_coche.php` para validar el nodo generado con los datos introducidos en el formulario en `index.php`

#### files/coches.xsl
Hoja de estilo para transformar `files/coches.xml` a HTML.
Se aplica al leer `files/coches.xml` directamente.
No se utiliza en la aplicación.