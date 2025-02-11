<?php
require_once 'C:\Users\youco\Desktop\twig-workshop\entities\User.php';
require_once 'C:\Users\youco\Desktop\twig-workshop\model\UserModel.php';
require_once'C:\Users\youco\Desktop\twig-workshop\model\impl\UserModelimpl.php';


class UserControllerimpl
{

    private UserModelimpl $userModel;
    public function __construct()
    {
        $this->userModel = new UserModelimpl();
    }

    
    public function save(User $person): bool
{
    try {
        
        $person = new User($_POST["email"], $_POST["password"], $_POST["name"]);

        return $this->userModel->save($person);
    } catch (Exception $e) {
        return false;
    }
}

    public function verifyUser(User $person): array|bool
    {
        try{
            $person= new User($_POST["email"], $_POST["password"],'') ;
               return  $this->userModel->verifyUser($person);
        }
        catch(Exception $e){   
            return false;

    }
       
    }
    public function getAllUsers(): array|bool {
        try {
            $result=$this->userModel->getAllUsers();
            return $result;
        }
        catch (Exception $e) {
            return false ;

    }
    }
         
}
?>