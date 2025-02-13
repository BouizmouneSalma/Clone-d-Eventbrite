<?php
require_once 'C:\Users\youco\Desktop\MyEvenT\model\UserModel.php';
require_once 'C:\Users\youco\Desktop\MyEvenT\config\database.php';

class UserModelimpl implements UserModel
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function save(User $user): bool
    {
     
        $query = "INSERT INTO users (name , email, password ) values (:name , :email, :password )";

        try {
            $stmt = $this->conn->prepare($query);
            
            return $stmt->execute(
                [
                    ':name' => $user->getName(),
                    ':email' => $user->getEmail(),
                    ':password' => $user->getPassword()
              
                ]
            );

            
        } catch (Exception $e) {
            throw new Exception("error while saving user into database");
        }
    }

    public function verifyUser(User $user): array|bool
    {
        $email = $user->getEmail();
        $password = $user->getPassword();
        $query = "SELECT * FROM users WHERE email = :email";
        $statement = $this->conn->prepare($query);
        $statement->bindParam(':email', $email);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if ($result && password_verify($password, $result['password'])) {
            return $result;
        }
        return false;
    }
    public function logout (): void{
            session_destroy();
            session_unset();
    }
    public function getAllUsers(): array {
        $query = "SELECT * FROM users";
        $statement = $this->conn->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>