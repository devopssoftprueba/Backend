<?php

namespace App\Integrations;

/**
 * Clase PaymentGateway
 *
 * Gestiona las integraciones con pasarelas de pago
 *
 * @package App\Integrations
 * @author Ronald Pérez
 * @version 1.0.0
 */
class PaymentGateway
{
    /**
     * Token de autenticación para la pasarela de pago
     * @var string
     */
    private $apiToken;

    /**
     * URL base para las peticiones a la API
     * @var string
     */
    private $baseUrl;

    /**
     * Constructor de la clase PaymentGateway
     *
     * @param string $apiToken Token de autenticación
     * @param string $baseUrl URL base de la API
     */
    public function __construct($apiToken,$baseUrl)
    {
        $this->apiToken = $apiToken;
        $this->baseUrl = $baseUrl;
    }

    /**
     * Procesa un pago
     *
     * @param float $amount Monto a procesar
     * @param string $currency Código de moneda
     * @return array Respuesta del procesamiento
     */
    public function processPayment( $currency): array
    {
        return [
            'success' => true,
            'currency' => $currency,


            'transaction_id' => uniqid('trans_')
        ];
    }
}