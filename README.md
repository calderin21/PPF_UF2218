# Desarrollo de componentes para la integración con repositorio

## Objetivo

El alumnado debe comprender y aplicar el manejo de ficheros **XML** como sistema de almacenamiento estructurado, integrándolo en una aplicación web desarrollada con **PHP**.  
Además, deberán implementar un sistema básico de **autenticación** y **gestión de permisos por roles**.

---

## Enunciado del ejercicio

Se te proporciona una aplicación web funcional que permite **insertar y eliminar coches** registrados en un fichero XML.
https://github.com/calderin21/PPF_UF2218/

### 🛠Deberás realizar las siguientes tareas:

---

### 1. Analizar el funcionamiento de cada fichero proporcionado

Explica en un documento `.md` el propósito de cada archivo:

- Archivos PHP
- Archivo XML
- Esquema XSD
- Hoja de estilo XSL

---

### 2. ✏Ampliar la funcionalidad del CRUD

- Añadir una opción para **modificar** un coche ya existente.
- Mostrar un listado de coches con una interfaz visual **más atractiva** utilizando `coches.xsl`.

---

### 3. Validación del esquema XML

- Validar que los datos del XML cumplen con el esquema `coches.xsd` tras cada operación (inserción, modificación, eliminación).

---

### 4. ⚠Control de errores

Implementa mensajes de error o alertas para los siguientes casos:

- Inserción de **matrícula duplicada**
- Eliminación o modificación de un coche que **no existe**

---

### 5. Implementar sistema de login con roles

Debes crear un sistema de autenticación mediante formulario `login.php` que distinga entre dos tipos de usuarios:

#### Usuario **administrador**
- Puede **insertar, modificar y eliminar** coches.

#### Usuario **consultor**
- Solo puede **consultar y buscar** coches (no puede realizar ediciones).

Requisitos:

- Almacenar las credenciales en un archivo `usuarios.xml`
- Al hacer login, mantener la sesión activa.
- Proteger las páginas con comprobación de permisos.
- Mostrar un mensaje claro si el usuario no tiene permisos para una acción.

---

### 6. Crear el script `buscar_coche.php`

- Permite buscar coches por **marca** o **modelo** desde un formulario HTML.

---

### 7.  Documentación técnica

Crea un archivo `README.md` (este archivo) que incluya:

- La estructura del sistema (carpetas y archivos)
- Cómo se realiza cada operación (insertar, eliminar, modificar, buscar)
- Validaciones aplicadas
- Gestión de roles
- Capturas de pantalla de las pruebas funcionales

---

### 8. Modo de entrega

Comparte con el docente un **repositorio GitHub** con el nombre:  
`PPF_[Nombre_del_alumno]`

---

<p align="right"><strong>¡Ánimo!</strong></p>
