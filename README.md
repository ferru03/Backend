Per far funzionare il Back-End abbiamo bisogno di Docker.

Windows:
Scaricare Docker Desktop per Windows. Avviare il file.exe scaricato e seguire i passaggi di installazione.

Dopo la corretta installazione Docker funziona. Per avviare il Back-End consiglio di utilizzare il prompt dei comandi.

ABisogna avviare Apache e Mysql tramite Docker.

Mysql:

scaricare il database create_employee.sql e lanciare i seguenti comandi:

1) Per avviare il container con mysql-server: docker run --name my-mysql-server --rm -v C:\Users\andre\OneDrive\Documenti/var/lib/mysql -v
C:\Users\andre\OneDrive\Documenti/dump -e MYSQL_ROOT_PASSWORD=my-secret-pw -p 3306:3306 -d mysql:latest

Spiegazione comandi:

--name = nome container. 
--rm = rimozione container. 
-v = percorso della cartella della macchina fisica
MYSQL_ROOT_PASSWORD = password.
-p = porta container.

2) Per ottenere la bash dentro il container: docker exec -it my-mysql-server bash

Spiegazione comandi:

-it = interfaccia associata al nome del container
bash = otteniamo un'interfaccia a linea di comando

3) Importazione del database: mysql -u root -p < /dump/create_employee.sql; exit;

Spiegazione comandi:

-u = indica l'utente
-p = questo parametro è necessario se viene definita una password per MYSQL
< = prende in input il file

Le volte succesive sarà necessario avviare il docker mysql tramite questo comando: docker run --name my-mysql-server --rm -v
C:\Users\andre\OneDrive\Documenti/var/lib/mysql -e MYSQL_ROOT_PASSWORD=my-secret-pw -p 3306:3306 -d mysql:latest

Apache:

1) Avviare il WebServer di apache: docker run -d -p 8080:80 --name my-apache-php-app --rm  -v C:\Users\andre\OneDrive\Documenti/var/www/html zener79/php:7.4-apache

Spiegazione comandi:
--name = nome container.
--rm = rimozione container. 
-v = percorso della cartella della macchina fisica
MYSQL_ROOT_PASSWORD = password MYSQL.
-p = porta container.
-d = Il docker avviato in background

Linux:

Su Ubuntu i comandi saranno gli stessi. L'unica cosa che cambia sarà il percorso.
