<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';

$subject = $_POST["subject"];
$content = $_POST["content"];
$content = nl2br($content);


$mail = new PHPMailer(true);

try {
    
    $mail->SMTPDebug = false;                     
    $mail->isSMTP();                                           
    $mail->Host       = 'smtp.gmail.com';                     
    $mail->SMTPAuth   = true;                                  
    $mail->Username   = 'vencent4462323@gmail.com';                    
    $mail->Password   = 'xxxxxxxxxx';                               
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           
    $mail->Port       = 465;                                    
    $mail->CharSet    = 'utf-8';
    $mail->setFrom('vencent4462323@gmail.com', 'Mailer');

    $link = @mysqli_connect( 
                'localhost',  
                'root',      
                '12345',  
                'PhP_SendLetter'); 
    if(!$link)
        die("無法開啟資料庫!<br/>");
    else
        echo "資料庫開啟成功!";
    
 
    $SQL = "SELECT * FROM SendLetter";
    $result = mysqli_query($link, $SQL);
    while($row = mysqli_fetch_assoc($result)){
        
        $Name = $row["Name"];
        $Email = $row["Email"];
        $mail->addAddress($Email, $Name);     /
    }
    $mail->addReplyTo('vencent4462323@gmail.com', 'Information');

  
    $mail->isHTML(true);                                  
    $mail->Subject = $subject;
    $mail->Body    = $content;
    

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

mysqli_close($link);

?>
