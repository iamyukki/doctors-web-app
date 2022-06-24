<?php 
    class Client{
        private $conn;
        private $fname,$lname,$email,$password;
        private $form_valid = array('isValid'=>true,'msg'=>"");

        public function __construct($conn, $fname, $lname, $email, $password) {
            $this->conn = $conn;
            $this->fname = $fname;
            $this->lname = $lname;
            $this->email = $email;
            $this->password = $password;
        }

        public function register(){
            if(!empty($this->fname) and !empty($this->lname) and !empty($this->email) and !empty($this->password) ){
                $sql = "INSERT INTO clients(first_name,last_name,email,password,profile_pic) VALUES('$this->fname','$this->lname', '$this->email','$this->password','default.png')";
                $result = mysqli_query($this->conn, $sql);

                if($result){
                    $_SESSION['role'] = "client";
                    $_SESSION['first_name']= $this->fname;
                    $_SESSION['last_name']= $this->lname;
                    $_SESSION['email']= $this->email;
                    $_SESSION['password']= $this->password;
                    $_SESSION['id']= $this->getId();
                    header("location:profile-settings.php");
                }

            }else{
                $this->setErrorMsg('All inputs must be filled');
            }
        }

        public function checkForm(){
            if(!$this->form_valid['isValid']){
                echo $this->form_valid['msg'];
            }
        }

        // " Fname + Lname + email " are already in session
        public function updateProfile($birth_date,$blood_type,$phone,$adresse,$city,$state,$zip_code,$profile_pic,$country){
            if($birth_date == "1970-01-01"){
                $this->setErrorMsg("Please insert a valid date");
                return; 
            }

            if($this->checkEmptyInputs($blood_type ,$phone ,$adresse ,$city ,$state ,$zip_code ,$profile_pic ,$country)){
                $this->setErrorMsg("All inputs must be filled");
                return;
            }
            $id = $_SESSION['id'];//Client id            
            $ext = '';$file_name = ''; $path = '';      
            
            $ext = pathinfo(basename($profile_pic['name']), PATHINFO_EXTENSION); //Client profile pic's extension

            if(!(in_array($ext,array('png','jpg','jpeg'))) and $profile_pic['size'] > 0){
                $this->setErrorMsg("Image format not supported");
                return;                                            
            }
            if($profile_pic['size'] > 0 and in_array($ext,array('png','jpg','jpeg')) ){
                $file_name = "$id.$ext";
                $path = "assets/img/patients/$file_name";
                move_uploaded_file($profile_pic['tmp_name'],$path);
            }

            if( ((new DateTime())->diff(new DateTime($birth_date))->y) < 18 ){
                $this->setErrorMsg("You must be older than 18 years");
                return;                                
            }

            $sql = "UPDATE clients SET first_name = '$this->fname' , last_name = '$this->lname', 
                    phone = '$phone', email = '$this->email' , birth_date = '$birth_date', 
                    adresse = '$adresse', city = '$city', 
                    state = '$state', zip_code = $zip_code, 
                    country = '$country', blood_type = '$blood_type'";

                    if($profile_pic['size'] > 0){
                        $sql .= ", profile_pic = '$file_name' WHERE idClient = $id";
                    }
                    else{
                        $sql .=  " WHERE idClient = $id ";
                    }
                    
            $res = mysqli_query($this->conn, $sql);
            if($res){
                $this->setSuccessMsg("Data updated successfully");
                $_SESSION['first_name']= $this->fname;
                $_SESSION['last_name']= $this->lname;
                $_SESSION['email']= $this->email;
                return;

            }else{
                $this->setErrorMsg("Can't update your data to the database");
            }
        }

        public function addReview($stars,$title,$text,$idDoc){
            $sql = "INSERT INTO reviews(idDoctor,idClient,stars,review_text,title)VALUES($idDoc,".$_SESSION['id'].",$stars,'$text','$title')";
            $res = mysqli_query($this->conn,$sql);
            if($res){
                // $this->setSuccessMsg("Comment added");
                // unset($_POST['subReview']);
                header("location:doctor-profile.php?idDoc=$idDoc");
            }else{
                // $this->setErrorMsg('Can\'t add to database');
                return;
            }
        }

        private function getId(){
            $sql = "SELECT idClient FROM clients WHERE email = '$this->email' AND password = '$this->password'";
            return mysqli_fetch_assoc(mysqli_query($this->conn,$sql))['idClient'];
        }

        public function updatePassword($newPass,$confirmPass){
            if($this->checkEmptyInputs($this->password,$newPass,$confirmPass)) {
                $this->setErrorMsg("All inputs must be filled");
                return;
            }
            $sql = "SELECT * FROM clients WHERE email = '$this->email' AND password = '$this->password'";
            $res = mysqli_query($this->conn, $sql);
            if(mysqli_num_rows($res) > 0){
                if($newPass === $confirmPass){
                    $sql = "UPDATE clients SET password = '$newPass' WHERE idClient = ". $_SESSION['id'];
                    $res = mysqli_query($this->conn, $sql);
                    if($res){
                        $this->setSuccessMsg("Password updated successfully");
                        $_SESSION['password'] = $newPass;
                    }else{
                        $this->setErrorMsg("Can't update your password to the database");
                    }
                }else{
                    $this->setErrorMsg("Passwords don't match");
                }
                
            }else{
                $this->setErrorMsg("Old password is incorrect");                               
            }
        }

        public function checkoutCC($fname,
                                $lname,
                                $email,
                                $phone,
                                $cc_name,
                                $cc_number,
                                $cc_month,
                                $cc_year,
                                $cvv,
                                $total,
                                $idDoc){
            if($this->checkEmptyInputs($fname,$lname,$email,$phone,$cc_name,$cc_number,$cc_month,$cc_year,$cvv)){
                $this->setErrorMsg('All inputs must be filled');
                return;
            }

            $sql = "INSERT INTO checkouts(idClient,payment_type,nameOnCard,cardNumber,expiryYear,expiryMonth,cvv,total,date)
                    VALUE(".$_SESSION['id'].",'cc','$cc_name','$cc_number','$cc_year','$cc_month','$cvv',$total,CURDATE())";
            $sql2 = "INSERT INTO appointments(idDoctor,idClient,date)
                    VALUE($idDoc,".$_SESSION['id'].",CURDATE())";
            $res = mysqli_query($this->conn,$sql);
            $appointement = mysqli_query($this->conn,$sql2);
            if($res and $appointement){
                $_SESSION['idDoc'] = $idDoc;
                $_SESSION['date'] = new DateTime();
                header('location:booking-success.php');
            }else{
                $this->setErrorMsg('Can\' connect to the database');
            }
        }
        public function checkoutCash($fname,$lname,$email,$phone,$total,$idDoc){
            if($this->checkEmptyInputs($fname,$lname,$email,$phone)){
                $this->setErrorMsg('All inputs must be filled');
                return;
            }
            $sql1 = "INSERT INTO checkouts(idClient,payment_type,total,date)
                    VALUE(".$_SESSION['id'].",'cash',$total,CURDATE())";

            $sql2 = "INSERT INTO appointments(idDoctor,idClient,date)
                    VALUE($idDoc,".$_SESSION['id'].",CURDATE())";

            $booking = mysqli_query($this->conn,$sql1);
            $appointement = mysqli_query($this->conn,$sql2);

            if($booking and $appointement){
                $_SESSION['idDoc'] = $idDoc;
                $_SESSION['date'] = new DateTime();
                header('location:booking-success.php');
            }else{
                $this->setErrorMsg('Can\' connect to the database');
            }
        }


        private function checkEmptyInputs(){
            for ($i=0; $i < func_num_args(); $i++) { 
                if(empty(func_get_arg($i))){
                    return true;
                }
            }
            return false;
        }

        private function setErrorMsg($msg){
            $this->form_valid['isValid'] = false;
            $this->form_valid['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>".
                                            "<strong>Error!</strong> $msg!.".
                                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                                                '<span aria-hidden="true">&times;</span>'.
                                            '</button>'.
                                        '</div>';
        }
        private function setSuccessMsg($msg){
            $this->form_valid['isValid'] = false;
            $this->form_valid['msg'] = "<div class='alert alert-info alert-dismissible fade show' role='alert'>".
                                            "<strong>Success!</strong> $msg!.".
                                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                                                '<span aria-hidden="true">&times;</span>'.
                                            '</button>'.
                                        '</div>';
        }
    }

?>