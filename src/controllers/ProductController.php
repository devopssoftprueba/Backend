<?php

/**
 * Clase que representa el perfil de un usuario.
 *
 * Esta clase contiene las propiedades relacionadas con el perfil de un usuario, como su nombre y su edad.
 * Además, proporciona métodos para establecer y obtener estos valores.
 *
 * @category UserManagement
 * @package  UserProfilePackage
 * @author   Tu Nombre
 * @version  1.0.0
 * @since    2025-04-15
 */
class UserProfile
{
    /**
     * 
     *
     * Esta propiedad almacena el nombre del usuario. Se utiliza en el sistema para identificar al usuario.
     *
     * @var string $userName Variable con el nombre del usuario.
     */
    private $userName;

    /**
     * Edad del usuario.
     *
     * Esta propiedad almacena la edad del usuario. Es utilizada para determinar la edad del usuario en el sistema.
     *
     * @var integer $userAge Variable con la edad del usuario.
     */
    private $userAge;

    /**
     * Establece el nombre del usuario.
     *
     * Este metodo asigna el valor proporcionado al nombre del usuario. El valor de `$userName` es una cadena de texto
     * que representa el nombre completo del usuario.
     *
     * @param string $userName Nombre del usuario.
     *
     * @return void
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * Obtiene el nombre del usuario.
     *
     * @return string $username variable donde está el nombre.
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Establece la edad del usuario.
     *
     * Este metodo asigna la edad del usuario. La edad debe ser un valor entero que represente la edad actual
     * del usuario en años.
     *
     * @param int $userAge Edad del usuario.
     *
     * @return void
     */
    public function setUserAge(int $userAge)
    {
        $this->userAge = $userAge;
    }

    /**
     * Obtiene la edad del usuario.
     *
     * Este metodo devuelve la edad almacenada del usuario.
     *
     * @return integer Edad del usuario.
     */
    public function getUserAge()
    {
        return $this->userAge;
    }
    /**
     * Metodo de prueba que simula una operación con try-catch.
     *
     * Este metodo solo sirve para verificar que el try-catch cumple con las reglas del validador.
     *
     * @return void
     */
    public function doSomething()
    {
        try {

            // Simulando una operación
            $result = 10 / 2;
        } catch (\Throwable $e) {
            // Captura del error
            $this->userName = 'Error';
        }
    }

}
