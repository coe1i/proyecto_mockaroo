### proyecto_mockaroo

 #Lista de mejoras: 

- Mostrar en detalles y en modificar la opción de siguiente y anterior  ✔️

- Mostrar la lista de clientes con distintos modos de ordenación: nombre, apellido, correo electrónico, género o IP y poder navegar por ella. ✔️

- Mostrar en detalles una bandera del país asociado a la IP ( utilizar geoip y  https://flagpedia.net/ )✔️

- Mejorar las operaciones de Nuevo y Modificar para que chequee que los datos son correctos:  correo electrónico (no repetido), IP y  teléfono con formato 999-999-9999. ✔️

- Mostrar una imagen asociada al cliente almacenada previamente en uploads o una imagen por defecto aleatoria generada por https://robohasp.org.  sin no existe. En nombre de las fotos tiene el formato 00000XXX.jpg para el cliente con id XXX. ✔️

- Generar un PDF con los todos detalles de un cliente ( Incluir un botón que indique imprimir) ✔️

- Controlar el acceso a la aplicación en función del rol, si es 0 solo puede acceder a visualizar los datos: lista y detalles. Si el rol es 1 podrá además modificar, borrar y eliminar usuarios. ✔️

- Utilizar geoip y el api para javascript https://openlayers.org o similar para mostrar la localización geográfica del cliente  en un mapa en función de su IP. ✔️

