# Panel de control (Transportes JR)

[Descripción general del proyecto]
Esta es una aplicación web creada para la empresa Transportes JR en Guatemala aunque es posible usarlo en otras empresas de lógistica o adaptarla. El sitema ofrece un sistema completo de gestión de usuarios, roles y control de acceso.
Con esta herramienta, puedes crear, editar y eliminar usuarios, asignar roles y permisos, generar reportes, imprimir guías, etc. El sistema sigue agregando más funcionalidades conforme se piden y requieren.

## Características principales

- Registro de usuarios: Crea nuevos usuarios y almacena su información personal y de contacto en una base de datos segura.
- Sistema de roles: Asigna roles y permisos a los usuarios para controlar su acceso a diferentes funcionalidades y secciones del sistema.
- Control de acceso: Garantiza la seguridad y privacidad de la información al restringir el acceso a funciones y datos sensibles según los roles asignados.
- Generación de reportes: Crea reportes PDF y EXCEL en diferentes secciones.
- Impresión de guías: Permite generar e imprimir guías y documentación necesaria para los usuarios.
- Registro de combustibles: Lleva un seguimiento de los consumos de combustibles, con la capacidad de registrar y visualizar datos relacionados.

## Tecnologías utilizadas

- Javascript, HTML y CSS
- PHP
- MySQL
- Jquery, SweetAlert

## Instalación

Para poder usarlo en un servidor local, se requiere:
- Clonar el reprositorio.
- Modificar en el archivo "conexion.php" el usuario, contraseña y base de datos.
- En la base de datos tener como mínimo las tablas Usuarios, Permisos y Asignaciones.

## Uso

Si se instala correctamente el proyecto:
- Se debe ingresar primero a "create.php" para crear el primer usuario (El usuario se crea desde la web para que la contraseña se encripte)
- Se debe logear con el usuario y contraseña

Y después de eso, ya se podria acceder al inicio del sistema, se deben asignar los roles en la db para que pueda acceder a las diferentes secciones y funcionalidades. El resto es algo intuitivo.

## Licencia

Este proyecto está licenciado bajo la [Licencia Creative Commons Attribution 4.0](./LICENSE). Por favor, consulta el archivo LICENSE para más detalles.
