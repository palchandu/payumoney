<?php
session_start();
include('classes/DBConnect.php');
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>PayU Money Gateway</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="container" style="text-align: center;">
	  <div class="row">
		  <img src="https://www.engineersinstitute.com/logopmt.jpg">
	  </div>
      </div>
        <div style="background: #f5f5f5;top: 108.813px;left: 384.5px;display: block;" id="dialog" class="window">

        <div id="san" style="text-align: center;">

        <a href="#" class="close agree"></a>

        <h1 style="font-size: 66px;font-weight: bold;color: #333;padding-top: 5%;" align="center">Thank You!</h1>
          <?php
          $status=$_POST["status"];
          $firstname=$_POST["firstname"];
          $amount=$_POST["amount"]; //Please use the amount value from database
          $txnid=$_POST["txnid"];
          $posted_hash=$_POST["hash"];
          $key=$_POST["key"];
          $productinfo=$_POST["productinfo"];
          $email=$_POST["email"];
          $bank_ref_num=$_POST["bank_ref_num"];
          $payment_mode=$_POST['mode'];
          $card_category=$_POST['cardCategory'];
          $payment_date=$_POST['addedon'];
          $cardnum=$_POST['cardnum'];
          $name_on_card=$_POST['name_on_card'];
          $salt="pjVQAWpA"; //Please change the value with the live salt for production environment
          $uid=$_SESSION['ins_id'];
          //Validating the reverse hash
          // If (isset($_POST["additionalCharges"])) {
          //        $additionalCharges=$_POST["additionalCharges"];
          //       $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
          // }else {
          //      $retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
          //  }
          // $hash = hash("sha512", $retHashSeq);
          try {
            $sqlverup=$dbo->prepare("update info_payment set txn_id='".$txnid."',reference_id='".$bank_ref_num."',payment_status='".$status."',payment_mode='".$payment_mode."',card_categoty='".$card_category."',payment_date='".$payment_date."',cardnum='".$cardnum."',name_on_card='".$name_on_card."' where id=$uid and deleted='N'");
            $updtRes=$sqlverup->execute();
            if($updtRes){
              $sqluser=$dbo->prepare("select * from info_payment where id=$uid");
              $sqluser->execute();
              $row = $sqluser->fetch(PDO::FETCH_ASSOC);
              $infos=[
              'amount'=>$row['amount'],
              'fullname'=>$row['fullname'],
              'email'=>$row['email'],
              'phone'=>$row['phone'],
              'product_info'=>$row['product_info'],
              'address'=>$row['address'],
              'state'=>$row['state'],
              'pincode'=>$row['pincode'],
              'branch'=>$row['branch'],
              'remarks'=>$row['remarks'],
              'paymentpurpose'=>$row['paymentpurpose'],
              'txnid'=>$txnid,
              'status'=>$status
            ];
              $response=$obj->send__mail($infos,'user');
              $response1=$obj->send__mail($infos,'admin');
              if ($status=='success' && $bank_ref_num!='') {
                session_destroy();
                unset($_SESSION['ins_id']);
                echo "<h3>Thank You, " . $firstname .".Your order status is ". $status .".</h3>";
                 "<h4>Your Transaction ID for this transaction is ".$txnid.".</h4>";
              }
              else {
              session_destroy();
              unset($_SESSION['ins_id']);

               echo "Transaction has been tampered. Please try again";
              }

            }
          } catch (PDOException $e) {
            print "Your fail message: " . $e->getMessage();
          }
          ?>

        <img src="https://cdn.iconscout.com/icon/free/png-256/right-true-verify-perfect-trust-64-32776.png" width="20%"><br><br>

        <p style="text-align: center;">  Have a Great Day! </p>

        <br>

        <p style="text-align: center;">
        <span style="align-items: center;float: none;text-align: center;">
        <a href="http://localhost/payu" target="_blank">
        <button type="button" style="text-align: center;background-color:#339900;" class="btn btn-info btn-lg" data-toggle="modal">Back to Home</button>
        </a>
        </span>
        </p>

        <br><br><br>

        </div>
        </div>
   </div>
</div>
</body>
</html>
