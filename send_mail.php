<?php
session_start();

include "./include/variable.php";
$page_description = "一鍵去信控煙辦";
$info_title = "Silent Blue";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './include/PHPMailer/src/Exception.php';
require './include/PHPMailer/src/PHPMailer.php';
require './include/PHPMailer/src/SMTP.php';

$now = time();
if(empty($_SESSION['expire']) || $now > $_SESSION['expire'])
{
    $reportType = $_POST['reportType'];
    $reportDate = $_POST["reportDate"];
    $reportStartTime = $_POST["reportStartTime"];
    $reportEndTime = $_POST["reportEndTime"];
    $address = $_POST["address"];
    $lastName = $_POST["lastName"];
    $title = $_POST["title"];
    $email = $_POST["email"];
    //$bcc = !empty($_POST["bcc"]);
    $selectTemplate = $emailList[searchListWithId(((int)$reportType), $emailList)];
    $selectAddress = $addressList[searchListWithId(((int)$address), $addressList)];
    $selectTitle = $titleList[searchListWithId(((int)$title), $titleList)];
    $subject = $selectTemplate["subject"];
    $to = $selectTemplate["to"];
    $emailTemplate = nl2br(file_get_contents($selectTemplate["template"]));
    $emailTemplate = str_replace("{{address}}", $selectAddress["address"], $emailTemplate);
    $emailTemplate = str_replace("{{reportDate}}", $reportDate, $emailTemplate);
    $emailTemplate = str_replace("{{reportStartTime}}", $reportStartTime, $emailTemplate);
    $emailTemplate = str_replace("{{reportEndTime}}", $reportEndTime, $emailTemplate);
    $emailTemplate = str_replace("{{lastName}}", $lastName, $emailTemplate);
    $emailTemplate = str_replace("{{title}}", $selectTitle["name"], $emailTemplate);

    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'sg2plcpnl0224.prod.sin2.secureserver.net';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'username';                 // SMTP username
        $mail->Password = 'password';                           // SMTP password

        $mail->SMTPSecure = true;                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to
        $mail->CharSet = 'UTF-8';

        //Recipients
        $mail->setFrom($email);
        $mail->addAddress($to);     // Add a recipient
        //$bcc ? $mail->addBCC($email) : '' ;

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $emailTemplate;

        $mail->send();

        $_SESSION['start'] = time();
        $_SESSION['expire'] = $_SESSION['start'] + (60 * 60);
        //echo 'Message has been sent';
        $sent = true;
    } catch (Exception $e) {
        //echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        $sent = false;
    }
}else{
    header("Location: /");
    die();
}


?>
<!DOCTYPE html>
<html lang="en">
<?php include "./inc_meta.php"; ?>
<body>

<div class="container-fluid pt-4 pb-4">

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Silent Blue</h3>
                    <?php
                    if($sent)
                    {
                    ?>
                        <img src="<?=$host_name?>images/send-ok.png" style="max-width: 100%;"/>
                        <p>你現在可以放心關機</p>
                    <?php
                    }else{
                    ?>
                        <img src="<?=$host_name?>images/send-fail.png" style="max-width: 100%;"/>
                        <a href="/">返去再send過</a>
                    <?php
                    };
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">

        </div>
    </div>


</div>

</body>
<?php include "./inc_js.php"; ?>
</html>
