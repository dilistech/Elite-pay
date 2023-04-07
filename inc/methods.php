<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function logs($user_id,$ip_address,$activity){
     require 'database.php';

       $sql = 'INSERT INTO logs (user_id,ip,activity)
         VALUES (:user_id,:ip,:activity)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id,'ip' => $ip_address,'activity' => $activity]);
        
}


function send_email($to,$subject,$first_name, $last_name,$body,$maill){
    //   require 'phpmailer/vendor/autoload.php';
        $mail = $maill;       
        
    try {        
            $mail->isSMTP();
            
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;

            $mail->Host = 'smtp.gmail.com';

            $mail->Port = 587;

            $mail->SMTPSecure = 'tls';

            $mail->SMTPAuth = true;

            $mail->Username = 'elitepay.net@gmail.com';

            $mail->Password = 'Letsgoin7';

            $mail->setFrom('elitepay.net@gmail.com','Elite-pay');
            $mail->addAddress($to, $first_name . ' ' . $last_name);     //Add a recipient 
            
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = strip_tags($body);

            $mail->send(); 

           
             
    
    } 
    catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function upload_file($file,$allowed_extensions,$user_id){ 
  
  require 'database.php';
  require '../config.php';
      $file_name = $file['name'];
       $file_temp_name = $file['tmp_name'];
       $file_size = $file['size'];
       $file_error = $file['error'];
       $file_type = $file['type'];        
       $file_ext = explode('.',$file_name);   
       
       $file_actual_ext = strtolower(end($file_ext));
       $allowed_files = $allowed_extensions;
  if (in_array($file_actual_ext,$allowed_files)) {
           if ($file_error === 0 ) {
               if ($file_size < 2000000) {
                   $file_new_name = uniqid('',true).'.'.$file_actual_ext;                                    
                   $file_dest = ROOT_FOLDER.$file_new_name;
                   move_uploaded_file($file_temp_name,$file_dest);        
                                           
                   $update_sql = 'UPDATE user SET dp = :file_new_name Where id = :id LIMIT 1';
                    $update = $pdo->prepare($update_sql);        
                    $update->execute(['file_new_name' => $file_new_name,'id' => $user_id]);
                    header('location:account-settings.php?status=updated');
                    
               }
               else {
                  $error ="Choose a file less than 1MB!"; 
                                  
               }
           }
           else {               
               $error = "There was an error uploading your file!";
           }
       }
       else {       
           $error ="you cannot upload files of this type!";
       }
       
}

function update_bio($data){ 
 
      require '../inc/database.php';
       $update_sql = 'UPDATE user SET first_name = :first_name,last_name = :last_name,
       phone = :phone,email = :email,bank = :bank,account_number = :account_number
        Where id = :id LIMIT 1';
        $update = $pdo->prepare($update_sql);        
        $update->execute(['first_name' => $data['first_name'],'last_name' => $data['last_name'],
        'phone' => $data['phone'],'email' => $data['email'],'bank' => $data['bank'], 
        'account_number' => $data['account_number'],'id' => $data['id']]);
        
        header('location:account-settings.php?status=updated');
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function get_selected_crypto($id, $currency){
    $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest';
  $parameters = [  
    'id' => $id,
    'convert' => $currency
    
  ];

  $headers = [
    'Accepts: application/json',
    'X-CMC_PRO_API_KEY: 46ca7af0-a404-4984-a898-3558d5ae9cac'
  ];
  $qs = http_build_query($parameters); // query string encode the parameters
  $request = "{$url}?{$qs}"; // create the request URL


  $curl = curl_init(); // Get cURL resource
  // Set cURL options
  curl_setopt_array($curl, array(
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_URL => $request,            // set the request URL
    CURLOPT_HTTPHEADER => $headers,     // set the headers 
    CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
  ));

  $response = curl_exec($curl); // Send the request, save the response
  // $dec = json_decode($response );
  // print_r($response); // print json decoded response
  return $response;


  curl_close($curl); // Close request
}
?>