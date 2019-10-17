<?php
/**
 * DB Connect
 */
class DBConnect
{
  public $dbo;
  public function __construct() {
  	 global $dbo;
     $host_name = "localhost";
     $database = "mytest"; // Change your database nae
     $username = "root";          // Your database user id
     $password = "password";
  	 try {
  	$dbo = new PDO('mysql:host='.$host_name.';dbname='.$database, $username, $password);
    $dbo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  	} catch (PDOException $e) {
  	print "Error!: " . $e->getMessage() . "<br/>";

  	}

  	 }

     function send__mail($info_array,$type){
       if($type=='user')
       {
         $to = $info_array['email'];
         $subject = "Thank you";
         $message = '<html><head><title>HTML email</title></head>
         <body>
         <p>Thank for Register with us.Following are details.</p>
         <table>
         <tr>
         <td><strong>Name:</strong></td>
         <td>'.$info_array['fullname'].'</td>
         </tr>
         <tr>
         <td><strong>Amount:</strong></td>
         <td>'.$info_array['amount'].'</td>
         </tr>
         <tr>
         <td><strong>Contact No.:</strong></td>
         <td>'.$info_array['phone'].'</td>
         </tr>
         <tr>
         <td><strong>Transaction Id:</strong></td>
         <td>'.$info_array['txnid'].'</td>
         </tr>
         <tr>
         <td><strong>Payment Status:</strong></td>
         <td>'.$info_array['status'].'</td>
         </tr>
         </table>
         </body>
         </html>';
       // Always set content-type when sending HTML email
       $headers = "MIME-Version: 1.0" . "\r\n";
       $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
       // More headers
       $headers .= 'From: <webmaster@example.com>' . "\r\n";
       //$headers .= 'Cc: myboss@example.com' . "\r\n";
     }else if($type=='admin'){
       $to = "chandra.getwebsoftware@gmail.com";
       $subject = "User Register";
       $message = '<html><head><title>HTML email</title></head>
       <body>
       <p>Thank for Register with us.Following are details.</p>
       <table>
       <tr>
       <td><strong>Name:</strong></td>
       <td>'.$info_array['fullname'].'</td>
       </tr>
       <tr>
       <td><strong>Amount:</strong></td>
       <td>'.$info_array['amount'].'</td>
       </tr>
       <tr>
       <td><strong>Contact No.:</strong></td>
       <td>'.$info_array['phone'].'</td>
       </tr>
       <tr>
       <td><strong>Email.:</strong></td>
       <td>'.$info_array['email'].'</td>
       </tr>
       <tr>
       <td><strong>Branch.:</strong></td>
       <td>'.$info_array['branch'].'</td>
       </tr>
       <tr>
       <td><strong>Payment Purpose.:</strong></td>
       <td>'.$info_array['paymentpurpose'].'</td>
       </tr>
       <tr>
       <td><strong>Transaction Id:</strong></td>
       <td>'.$info_array['txnid'].'</td>
       </tr>
       <tr>
       <td><strong>Payment Status:</strong></td>
       <td>'.$info_array['status'].'</td>
       </tr>
       </table>
       </body>
       </html>';
     // Always set content-type when sending HTML email
     $headers = "MIME-Version: 1.0" . "\r\n";
     $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
     // More headers
     $headers .= 'From: <webmaster@example.com>' . "\r\n";
     }
     mail($to,$subject,$message,$headers);

     }
}
$obj=new DBConnect();

 ?>
