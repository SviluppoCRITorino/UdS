# UdS
Programma di gestione del servizio UdS del comitato della Croce Rossa di Torino

Seguito le guide per installare slim v4:

* https://www.slimframework.com/docs/v4/
* https://www.twilio.com/en-us/blog/create-restful-api-slim4-php-mysql

Configurazione:

```
$ php --version
PHP 8.3.4 (cli) (built: Mar 14 2024 22:31:53) (NTS)
Copyright (c) The PHP Group
Zend Engine v4.3.4, Copyright (c) Zend Technologies
    with Zend OPcache v8.3.4, Copyright (c), by Zend Technologies
```


# Installazione

Clona il progetto ed esegui 
```
composer update
```

dalla root del progetto (e.g., './UdS')

Configurare i dati del DB in 
```
./src/Models/DB.php
```

Creare un DB in mysql con una tabella e dei dati a caso. Per ora il DB è stato creato seguendo la guida in `https://www.twilio.com/en-us/blog/create-restful-api-slim4-php-mysql`

# Esecuzione
```
php -S localhost:8888 -t public/
```
