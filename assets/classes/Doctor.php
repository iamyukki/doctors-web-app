<?php 
    class Doctor{
        private $conn;
        private $fname,$lname,$email,$password;
        private $form_valid = array('isValid'=>true,'msg'=>"");
        public function __construct($conn,$fname,$lname,$email,$password) {
            $this->conn = $conn;
            $this->fname = $fname;
            $this->lname = $lname;
            $this->email = $email;
            $this->password = $password;
        }

        public function register(){
            if(!empty($this->fname) and !empty($this->lname) and !empty($this->email) and !empty($this->password) ){
                $sql = "INSERT INTO doctors(first_name,last_name,email,password,profile_pic) 
                VALUE('$this->fname','$this->lname', '$this->email','$this->password','default.png')";
                $result = mysqli_query($this->conn, $sql);

                if($result){
                    $_SESSION['role'] = "doctor";
                    $_SESSION['fname']= $this->fname;
                    $_SESSION['lname']= $this->lname;
                    $_SESSION['email']= $this->email;
                    $_SESSION['password']= $this->password;
                    $id = $this->getId();
                    $_SESSION['id'] = $id;

                    $res = mysqli_query($this->conn,"INSERT INTO clinics(idDoctor) VALUE($id)");
                    $res = mysqli_query($this->conn,"INSERT INTO doctors_contact_details(idDoctor) VALUE($id)");
                    $res = mysqli_query($this->conn,"INSERT INTO services(idDoctor) VALUE($id)");
                    $res = mysqli_query($this->conn,"INSERT INTO specializations(idDoctor) VALUE($id)");
                    $res = mysqli_query($this->conn,"INSERT INTO educations(idDoctor) VALUE($id)");
                    $res = mysqli_query($this->conn,"INSERT INTO experience(idDoctor) VALUE($id)");

                    if($res){
                        header("location:doctor-dashboard.php");
                    }else{
                        $this->setErrorMsg('Can\'t add to database');
                    }

                }else{
                    $this->setErrorMsg("Error in inserting to DB");
                }

            }else{

                $this->setErrorMsg("All inputs must be filled");
            }
        } //End register methode

        public function updateData( $profile_pic,
                                    $username,
                                    $phone,
                                    $gender,
                                    $birth_date,
                                    $about,
                                    $clinic_name,
                                    $clinic_adresse,
                                    $clinic_pic,
                                    $addr1,
                                    $addr2,
                                    $city,
                                    $state,
                                    $country,
                                    $postal_code,
                                    $price,
                                    $degree,
                                    $college,
                                    $completion_year,
                                    $hospital_name,
                                    $hospital_from,
                                    $hospital_to,
                                    $designation,
                                    $cat,
                                    $start_year){

            //Check if any of all inputs is empty
            if($this->checkEmptyInputs( $this->fname,
                                        $this->lname,
                                        $this->email,
                                        $username,
                                        $phone,
                                        $gender,
                                        $birth_date,
                                        $about,
                                        $profile_pic,
                                        $clinic_name,
                                        $clinic_adresse,
                                        $addr1,
                                        $city,
                                        $state,
                                        $country,
                                        $postal_code,
                                        $degree,
                                        $college,
                                        $completion_year,
                                        $hospital_name,
                                        $hospital_from,
                                        $hospital_to,
                                        $designation)){
                $this->setErrorMsg("All inputs must be filled");
                return;
            }
            if( ((new DateTime())->diff(new DateTime($birth_date))->y) < 18 ){
                $this->setErrorMsg("You must be older than 18 years");
                return;                                
            }

            $id = $_SESSION['id'];//Doctor id            
            $ext = ''; $file_name = ''; $path = '';      
            $clinic_ext = ''; $clinic_file_name = ''; $clinic_path = '';      
            
            //Verify profile pic
            $ext = pathinfo(basename($profile_pic['name']), PATHINFO_EXTENSION); //Doctor profile pic's extension
            if(!(in_array($ext,array('png','jpg','jpeg'))) and $profile_pic['size'] > 0){
                $this->setErrorMsg("Image format not supported");
                return;                                            
            }
            if($profile_pic['size'] > 0 and in_array($ext,array('png','jpg','jpeg')) ){
                $file_name = "$id.$ext";
                $path = "assets/img/doctors/$file_name";
                move_uploaded_file($profile_pic['tmp_name'],$path);
            }

            //Verify clinic pic
            $clinic_ext = pathinfo(basename($clinic_pic['name']), PATHINFO_EXTENSION); //Doctor clinic pic's extension
            if(!(in_array($clinic_ext,array('png','jpg','jpeg'))) and $clinic_pic['size'] > 0){
                $this->setErrorMsg("Image format not supported");
                return;                                            
            }
            if($clinic_pic['size'] > 0 and in_array($clinic_ext,array('png','jpg','jpeg')) ){
                $clinic_file_name = "$id.$clinic_ext";
                $clinic_path = "./assets/img/clinics/$clinic_file_name";
                move_uploaded_file($clinic_pic['tmp_name'],$clinic_path);
            }

            //verify Experience From and to dates
            if(!((new DateTime($hospital_to))->diff(new DateTime($hospital_from))->y) > 1){
                $this->setErrorMsg('Experience must be more than 1 year');
                return;
            }

            //Basic Informations SQL       
            $sql = "UPDATE doctors SET first_name = '$this->fname', last_name = '$this->lname',
                    email = '$this->email', username = '$username', 
                    username = '$username', phone = $phone,
                    gender = '$gender', birth_date = '$birth_date',
                    about = '$about', price = $price,
                    categorie = '$cat'";

                    if($profile_pic['size'] > 0){
                        $sql .= ", profile_pic = '$file_name'";
                    }
                    
                    $sql .=  " WHERE idDoctor = $id;";

            //Clinic SQL
            $clinicSql = "UPDATE clinics SET clinic_name = '$clinic_name' , clinic_adresse = '$clinic_adresse'";
                    if($clinic_pic['size'] > 0){
                        $clinicSql .= ", images = '$clinic_file_name'";
                    }

            $clinicSql .= " WHERE idDoctor = $id";
                    
            // Contact Details SQL
            $cdSql = "UPDATE doctors_contact_details SET adresse_line1 = '$addr1',
                    adresse_line2 = '$addr2' , city = '$city', `state` = '$state' ,
                    country = '$country' , postal_code = $postal_code
                    WHERE idDoctor = $id";

            // Education SQL
            $eduSql = "UPDATE educations SET degree = '$degree', institue = '$college',
                       year_of_completion = '$completion_year', year_of_start = '$start_year'
                       WHERE idDoctor = $id";

            //Hospital SQL
            $hospitalsql = "UPDATE experience SET hospital = '$hospital_name', from_date = '$hospital_from',
                            to_date = '$hospital_to', designation = '$designation'
                            WHERE idDoctor = $id";

            $res = mysqli_query($this->conn, $sql);
            $clinicRes = mysqli_query($this->conn,$clinicSql);
            $cdRes = mysqli_query($this->conn,$cdSql);
            $eduRes = mysqli_query($this->conn,$eduSql);
            $hospitalRes = mysqli_query($this->conn,$hospitalsql);

            if($res and $clinicRes and $cdRes and $eduRes and $hospitalRes){
                $this->setSuccessMsg("Data updated successfully");                
                $_SESSION['first_name']= $this->fname;
                $_SESSION['last_name']= $this->lname;
                $_SESSION['email']= $this->email;
            }else{
                $this->setErrorMsg('Can\'t update to the database');
            }

        }

        public function updatePassword($oldPass,$newPass, $confirmPass){
            if($this->checkEmptyInputs($newPass,$confirmPass)){
                $this->setErrorMsg("All inputs must be filled");
                return;
            }
            if($oldPass === $this->password){
                if($newPass == $this->password){
                    $this->setErrorMsg('Please insert a new password');
                    return;
                }
                if($newPass === $confirmPass){
                    $sql = "UPDATE doctors SET password = '$newPass' WHERE idDoctor = ".$_SESSION['id'];
                    $res = mysqli_query($this->conn,$sql);
                    if($res){
                        $this->setSuccessMsg('Data updated successfully');
                        $_SESSION['password'] = $newPass;
                    }

                }else{$this->setErrorMsg('Passwords don\'t match');}

            }else{$this->setErrorMsg('Old password is incorrect');}

        }

        public function checkForm(){
            if(!$this->form_valid['isValid']){
                echo $this->form_valid['msg'];
            }
        } //End chexkForm methode


        //Assistent methods
        private function getId(){
            $sql = "SELECT idDoctor FROM doctors WHERE email = '$this->email' AND password = '$this->password'";
            return mysqli_fetch_assoc(mysqli_query($this->conn,$sql))['idDoctor'];
        }
        private function checkEmptyInputs(){
            for($i=0; $i < func_num_args(); $i++){
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