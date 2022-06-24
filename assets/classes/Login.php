<?php
class Login{
    private $conn;
    private $email,$password;
    private $form_valid = array('isValid'=>true,'msg'=>"");

    public function __construct($conn,$email,$password) {
        $this->conn = $conn;
        $this->email = $email;
        $this->password = $password;
    }

    public function login(){
        if(!$this->checkInputs($this->email,$this->password)) return;
        //Check for clients
        $sql = "SELECT * FROM clients WHERE (email = '$this->email' OR phone = '$this->email') AND password = '$this->password'";
        $res = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($res) > 0){//Client exists
            $row = mysqli_fetch_assoc($res);
            $_SESSION['role'] = 'client';
            foreach($row as $key => $value){
                if($key == "idClient"){
                    $_SESSION['id'] = $value;
                    continue;
                }
                $_SESSION[$key] = $value;
            }
            header('location:index.php');

        }else{
            //check for doctors
            $sql = "SELECT * FROM doctors WHERE email = '$this->email' AND password = '$this->password'";
            $res = mysqli_query($this->conn,$sql);
            if(mysqli_num_rows($res) > 0){
                //Doctor exists
                $row = mysqli_fetch_assoc($res);
                
                $_SESSION['role'] = "doctor";

                foreach($row as $key => $value){
                    if($key == "idDoctor"){
                        $_SESSION['id'] = $value;
                        continue;
                    }
                    $_SESSION[$key] = $value;
                }
                header('location:doctor-dashboard.php');

            }else{
                //Check for Admin
                $sql = "SELECT * FROM admin WHERE email = '$this->email' AND password = '$this->password'";
                $res = mysqli_query($this->conn,$sql);

                if(mysqli_num_rows($res) > 0){//Admin exists
                    $row = mysqli_fetch_assoc($res);
                    $_SESSION['role'] = "admin";
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['password'] = $row['password'];
                    header('location:index.php');

                }else{// Login and Password don't exist
                    $this->form_valid['isValid'] = false;
                    $this->form_valid['msg'] =    '<div class="alert alert-success alert-dismissible fade show" role="alert">'.
                                            '<strong>Error!</strong> Wrong Email or Password.'.
                                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                                                '<span aria-hidden="true">&times;</span>'.
                                            '</button>'.
                                            '</div>';
                }
            }
        }

    }

    private function checkInputs($e,$p){
        if(!empty($e) and !empty($p)){
            return true;
        }
        $this->form_valid['isValid'] = false;
        $this->form_valid['msg'] =  '<div class="alert alert-success alert-dismissible fade show" role="alert">'.
                                    '<strong>Error!</strong> All inputs are required.'.
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                                        '<span aria-hidden="true">&times;</span>'.
                                    '</button>'.
                                    '</div>';
    }

    public function checkForm(){
        if(!$this->form_valid['isValid']){
            echo $this->form_valid['msg'];
        }
    }
}

?>