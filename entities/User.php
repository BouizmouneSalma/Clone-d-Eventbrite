<?php

class User {
    private int $id;
    private string $name;
    private string $email;
    private string $password;

    public function __construct( string $email, string $password, string $name) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
     
    }
    
    public function getId(): int {  
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    
}
?>
