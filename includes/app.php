<?php

require 'funciones.php';
// importar la db
require 'config/database.php';

require __DIR__ . '/../vendor/autoload.php';

// conectaro a la base de datos
$db = conectarDB();

use Model\ActiveRecord;

ActiveRecord::setDB($db);
