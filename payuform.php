<?php
session_start();
include('classes/DBConnect.php');
if(isset($_SESSION['ins_id']))
{
try {
  $uid=$_SESSION['ins_id'];
  $sqluser=$dbo->prepare("select * from info_payment where id=$uid and deleted='N'");
	$sqluser->execute();
	$row = $sqluser->fetch(PDO::FETCH_ASSOC);
  $amount=$row['amount'];
  $fullname=$row['fullname'];
  $email=$row['email'];
  $phone=$row['phone'];
  $product_info=$row['product_info'];
  $address=$row['address'];
  $state=$row['state'];
  $pincode=$row['pincode'];
  $branch=$row['branch'];
  $remarks=$row['remarks'];
  $paymentpurpose=$row['paymentpurpose'];
  //print_r($row);
} catch (PDOException $e) {
  print "Your fail message: " . $e->getMessage();
}

// Merchant key here as provided by Payu
$MERCHANT_KEY = "7rnFly"; //Please change this value with live key for production
$hash_string = '';
// Merchant Salt as provided by Payu
$SALT = "pjVQAWpA"; //Please change this value with live salt for production

// End point - change to https://secure.payu.in for LIVE mode
$PAYU_BASE_URL = "https://test.payu.in";

$action = '';

$posted = array();
if(!empty($_POST)) {
    //print_r($_POST);
  foreach($_POST as $key => $value) {
    $posted[$key] = $value;

  }
}

$formError = 0;

if(empty($posted['txnid'])) {
   // Generate random transaction id
  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
  $txnid = $posted['txnid'];
}
$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
if(empty($posted['hash']) && sizeof($posted) > 0) {
  if(
          empty($posted['key'])
          || empty($posted['txnid'])
          || empty($posted['amount'])
          || empty($posted['firstname'])
          || empty($posted['email'])
          || empty($posted['phone'])
          || empty($posted['productinfo'])

  ) {
    $formError = 1;
  } else {

	$hashVarsSeq = explode('|', $hashSequence);

	foreach($hashVarsSeq as $hash_var) {
      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_string .= '|';
    }

    $hash_string .= $SALT;


    $hash = strtolower(hash('sha512', $hash_string));
    $action = $PAYU_BASE_URL . '/_payment';
  }
} elseif(!empty($posted['hash'])) {
  $hash = $posted['hash'];
  $action = $PAYU_BASE_URL . '/_payment';
}
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
  <script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
    }
  </script>
  </head>
  <body onload="submitPayuForm()">
    <div class="container">
      <div class="panel panel-primary">
      <div class="panel-heading">Registration & Fee Payment</div>
        <div class="panel-body">
          <h3 class="text-center">Your Basic Information</h3>
          <br/>
          <?php if($formError) { ?>
            <span style="color:red">Please fill all mandatory fields.</span>
            <br/>
            <br/>
          <?php } ?>
          <form action="<?php echo $action; ?>" method="post" name="payuForm" >
            <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
            <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
            <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />

      	    <input type="hidden" name="surl" value="http://localhost/payu/response.php" />   <!--Please change this parameter value with your success page absolute url like http://mywebsite.com/response.php. -->
      		  <input type="hidden" name="furl" value="http://localhost/payu/response.php" /><!--Please change this parameter value with your failure page absolute url like http://mywebsite.com/response.php. -->
            <input type="hidden" name="amount" value="<?php echo (empty($posted['amount'])) ? $amount : $posted['amount'] ?>" />
            <input type="hidden" name="firstname" id="firstname" value="<?php echo (empty($posted['firstname'])) ? $fullname : $posted['firstname']; ?>" />
            <input type="hidden" name="email" id="email" value="<?php echo (empty($posted['email'])) ? $email : $posted['email']; ?>" />
            <input type="hidden" name="phone" value="<?php echo (empty($posted['phone'])) ? $phone : $posted['phone']; ?>" />
            <input type="hidden" name="productinfo" id="productinfo" value="<?php echo (empty($posted['productinfo'])) ? $product_info : $posted['productinfo'] ?>" />
            <input type="hidden" name="lastname" id="lastname" value="<?php echo (empty($posted['lastname'])) ? '' : $posted['lastname']; ?>" />
            <input type="hidden" name="address1" value="<?php echo (empty($posted['address1'])) ? $address : $posted['address1']; ?>" />
            <input type="hidden" name="address2" value="<?php echo (empty($posted['address2'])) ? $address : $posted['address2']; ?>" />
            <input type="hidden" name="city" value="<?php echo (empty($posted['city'])) ? '' : $posted['city']; ?>" />
            <input type="hidden" name="state" value="<?php echo (empty($posted['state'])) ? $state : $posted['state']; ?>" />
            <input type="hidden" name="country" value="<?php echo (empty($posted['country'])) ? '' : $posted['country']; ?>" />
            <input type="hidden" name="zipcode" value="<?php echo (empty($posted['zipcode'])) ? $pincode : $posted['zipcode']; ?>"/>
            <input type="hidden" name="udf1" value="<?php echo (empty($posted['udf1'])) ? $branch : $posted['udf1']; ?>" />
            <input type="hidden" name="udf2" value="<?php echo (empty($posted['udf2'])) ? $remarks : $posted['udf2']; ?>" />
            <input type="hidden" name="udf3" value="<?php echo (empty($posted['udf3'])) ? $paymentpurpose : $posted['udf3']; ?>" />
            <input type="hidden" name="udf4" value="<?php echo (empty($posted['udf4'])) ? '' : $posted['udf4']; ?>" />
            <input type="hidden" name="udf5" value="<?php echo (empty($posted['udf5'])) ? '' : $posted['udf5']; ?>" />
            <input type="hidden" name="pg" value="<?php echo (empty($posted['pg'])) ? '' : $posted['pg']; ?>" />
            <table class="table">
              <tbody>
                  <tr>
                      <td><strong>FullName :</strong></td>
                      <td><?php echo ucfirst($fullname); ?></td>
                  </tr>
                  <tr>
                      <td><strong>Email :</strong></td>
                      <td><?php echo $email; ?></td>
                  </tr>
                  <tr>
                      <td><strong>Phone No.:</strong></td>
                      <td><?php echo $phone; ?></td>
                  </tr>
                  <tr>
                      <td><strong>Amount :</strong></td>
                      <td>&#8377; <?php echo $amount; ?></td>
                  </tr>
                  <tr>
                      <td><strong>Branch :</strong></td>
                      <td><?php echo $branch; ?></td>
                  </tr>
                  <tr>
                      <td><strong>Payment Purpose :</strong></td>
                      <td><?php echo $paymentpurpose; ?></td>
                  </tr>
                  <tr>
                      <td><strong>Address :</strong></td>
                      <td><?php echo $address; ?></td>
                  </tr>
              </tbody>
          </table>
          <?php if(!$hash) { ?>
            <span style="margin-left: 45%;"><input class="btn btn-primary" type="submit" value="Pay Fee" /></span>
          <?php } ?>

          </form>
      </div>
    </div>
   </div>
  </body>
</html>
<?php
}
 ?>
