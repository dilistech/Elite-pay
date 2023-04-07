<?php 

if (isset($_GET['otp']) && isset($_GET['id'])) {
    $otp = $_GET['otp'];
    $id = $_GET['id'];
    include_once 'inc/database.php';
    $query = 'SELECT otp_code,verified_status FROM user WHERE id = :id LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id',$id);
    $stmt->execute();
    $row = $stmt->fetch();    
    if ($row) {
        if ($row->otp_code == $otp) {
        $sql = 'UPDATE user SET verified_status = 1 Where id = :id LIMIT 1';
        $update = $pdo->prepare($sql);        
        $update->bindParam(':id',$id);
        $update->execute();

        header('location: sign-in.php');
        }
        else{
            die('something went wrong');
        }     
        
    }    
}
else{
    die('something went wrong');
}

?>