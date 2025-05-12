<?php

/**
 */
class UserProfile
{
    /**
     * Nombre del usuario.
     *
     * Esta propiedad almacena el nombre del usuario. Se utiliza en el sistema para identificar al usuario.
     *
     * @var string $userName Variable con el nombre del usuario.
     */
    private $userName1;

    /**
     * Edad del usuario.
     *
     * Esta propiedad almacena la edad del usuario. Es utilizada para determinar la edad del usuario en el sistema.
     *
     * @var integer $userAge Variable con la edad del usuario dgdfgdfdf.
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
     * Metodo de prueba.php que simula una operación con try-catch.
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
