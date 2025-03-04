<?php
// Definir constantes del proyecto
define("urlsite", "http://localhost/SportNex/");
define("DB_NAME", "sportnex");
define("DB_USER", "root");
define("DB_PASS", "");

// Cargar autoload de Composer
require __DIR__ . '/vendor/autoload.php';

// Configurar Mercado Pago
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

MercadoPagoConfig::setAccessToken('APP_USR-1022145548778758-112009-6ac26072a143faad822c88139e3dfe1b');
