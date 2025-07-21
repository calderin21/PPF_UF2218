#  Documentación técnica
---
## La estructura del sistema (carpetas y archivos)
- README.md
- index.php
- login.php
- insertar_coche.php
- eliminar_coche.php
- editar_coche.php
- buscar_coche.php (*faltante*)
- files/
	- coches.xml
	- coches.xsd
	- coches.xsl
	- usuarios.xml
	- usuarios.xsd (*faltante*)
	- usuarios.xsl (*faltante*)
---
## Operaciones
#### insertar
1. Se carga el XML en PHP
2. Se añade un nodo coche con la información ofrecida en el formulario
3. Se genera un fichero temporal con el XML tras añadir el nuevo coche.
4. Se valida el fichero temporal con el XSD
5. Finalmente, se guarda el fichero temporal como el nuevo coches.xml
#### eliminar
1. Se carga el XML en PHP
2. Se busca y se elimina el coche con la matrícula especificada en el formulario.
3. Se genera un fichero temporal con el XML tras añadir el nuevo coche.
4. Se valida el fichero temporal con el XSD.
5. Finalmente, se guarda el fichero temporal como el nuevo coches.xml.
#### modificar
1. Se carga el XML en PHP
2. Se busca y se elimina el coche con la matrícula especificada en el formulario.
3. Se añade un nodo coche con la misma matrícula y el resto de la información ofrecida en el formulario.
4. Se genera un fichero temporal con el XML tras añadir el nuevo coche.
5. Se valida el fichero temporal con el XSD.
6. Finalmente, se guarda el fichero temporal como el nuevo coches.xml.
#### buscar
	La librería "DataTables" usada en el renderizado de la tabla ofrece un cuadro de búsqueda que permite filtrar las filas por un valor de cualquier columna.

---
## Validaciones aplicadas
#### Coches

*Coches* es la raíz del documento XML. Contiene una secuencia de **cero o más** elementos *coche*.

Un *coche* contiene una secuencia con los siguientes elementos:
- **marca**: contiene una cadena de texto
- **modelo**: contiene una cadena de texto
- **puertas**: contiene un entero cuyo valor es entre 2 y 5, ambos inclusive
- **color**: contiene una cadena de texto
- **precio**: contiene un entero; también posee un atributo obligatorio, llamado ***venta***, cuyo valor debe ser una de las siguientes cadenas: "*nuevo*", "*ocasión*" y "*segunda mano*".

Además, cada coche posee un atributo obligatorio, llamado ***matrícula***, cuyo valor debe ser una cadena formada por cuatro dígitos y tres letras mayúsculas.
#### usuarios
---
## Gestión de roles
Al entrar a la página principal, se comprueba si existe una sesión abierta en PHP (*$_SESSION*).
De no haber, se redirige a la página de *login*, donde el usuario debe rellenar el formulario con su correo electrónico y su contraseña. Las credenciales de los usuarios registrados aparecen en *files/usuarios.xml*.
Al enviarse el formulario, si se concede el acceso, se redirige a la página principal.
Dependiendo del rol del usuario (*$_SESSION["tipo"]*), la página mostrará más o menos controles para interactuar con la tabla.
Un *administrador* podrá hacer cambios en los datos; esto es, insertar coches en un formulario (o modificarlo, al pulsar el botón en la fila correspondiente); también podrá eliminar coches pulsando otro botón en la fila de la tabla.
Un *consultor* solamente podrá leer los datos disponibles; consultar la tabla y filtrar las filas de la misma (con el cuadro provisto por *DataTables*) 

