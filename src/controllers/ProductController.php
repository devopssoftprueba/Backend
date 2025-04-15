<?php

class UserProfile
{
    private string $userName;
    private int $userAge;

    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserAge(int $userAge)
    {
        $this->userAge = $userAge;
    }

    public function getUserAge()
    {
        return $this->userAge;
    }
}
