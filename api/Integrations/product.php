<?php

namespace App\Integrations;

/**
 * Clase PaymentGateway.
 *
 * Gestiona las integraciones con pasarelas de pago.
 *
 * @package App\Integrations
 * @author  Ronald pelaez.
 * @version 1.0.0.
 */
class PaymentGateway
{
    /**
     * Token de autenticación para la pasarela de pago.
     *
     * @var string.
     */
    private $apiToken;

    /**
     * URL base para las peticiones a la API.
     *
     * @var string.
     */
    private $baseUrl;

    /**
     * Constructor de la clase PaymentGateway.
     *
     * @param string $apiToken Token de autenticación.
     * @param string $baseUrl  URL base de la API.
     */
    public function __construct($apiToken,$baseUrl)
    {
        $this->apiToken = $apiToken;
        $this->baseUrl = $baseUrl;
    }

    /**
     *
     *
     * @param strin
     *
     *
     * @return array Respuesta del procesamiento.
     */
    public function processPayment($currency): array
    {
        return [
            'success' => true,
            'currency' => $currency,
            'transaction_id' => uniqid('trans_')
        ];
    }
}