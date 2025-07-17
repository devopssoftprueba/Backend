<?php
use GuzzekHttp\Client;

// Creo una instancia del cliente HTTP.
// ¿Qué es una instancia? Es un objeto creado a partir de una clase.
// En este caso, `Client` es una clase que nos permite hacer solicitudes HTTP (GET, POST, etc.)
$client = new Client();

// Hago una solicitud GET a una API externa.
// `get(...)` es un metodo de la clase Client que realiza una petición GET a la URL especificada.
// Esa URL pertenece a una API pública de clima, y devuelve datos del clima actual en Bogotá (latitud y longitud de Bogotá).
$response = $client->get('https://api.open-meteo.com/v1/forecast?latitude=4.6097&longitude=-74.0818&current_weather=true');
//solicitud GET a la API del clima

$data = json_decode($response->getBody(), true);
//convierto la respuesta JSON a un array asociativo

echo "El clima actual en Bogotá es: " , $data['current_weather']['temperature'] , "°C con viento de " , $data['current_weather']['windspeed'] , " km/h.\n";
