<?php
session_start();
if(isset($_SESSION['ins_id'])){
header("Location: payuform.php");
}
include('classes/DBConnect.php');
if(isset($_POST['SubmitButton'])){
  try{
  $message='';
  $firstname=(($_POST['firstname'])?$_POST['firstname']:'');
  $phone=(($_POST['phone'])?$_POST['phone']:'');
  $email=(($_POST['email'])?$_POST['email']:'');
  $amount=(($_POST['amount'])?$_POST['amount']:'');
  $productinfo=(($_POST['productinfo'])?$_POST['productinfo']:'');
  $whatsapp_num=(($_POST['whatsapp'])?$_POST['whatsapp']:'');
  $state=(($_POST['state'])?$_POST['state']:'');
  $branch=(($_POST['branch'])?$_POST['branch']:'');
  $remarks=(($_POST['remark'])?$_POST['remark']:'');
  $address=(($_POST['address'])?$_POST['address']:'');
  $pincode=(($_POST['pincode'])?$_POST['pincode']:'');
  $paymentpurpose=(($_POST['paymentpurpose'])?$_POST['paymentpurpose']:'');
  $captcha=(($_POST['captcha'])?$_POST['captcha']:'');
  $created=time();
  if($firstname!='' && $phone!='' && $email!='' && $amount!='' && $productinfo!=''){
    try{
      $sqluser=$dbo->prepare("select * from info_payment where email=:email and deleted='N'");
      $sqluser->bindParam(':email',$email,PDO::PARAM_STR, 255);
      $sqluser->execute();
		  $no=$sqluser->rowCount();
      if($no>0)
      {
        $message='User alredy exists with this email id';
      }else{
      $sql=$dbo->prepare("insert into info_payment set fullname=:fullname,phone=:phone,email=:email,amount=:amount,product_info=:product_info,whatsapp_num=:whatsapp_num,state=:state,branch=:branch,remarks=:remarks,address=:address,pincode=:pincode,paymentpurpose=:paymentpurpose,created=:created");
      $sql->bindParam(':fullname',$firstname,PDO::PARAM_STR, 255);
      $sql->bindParam(':phone',$phone,PDO::PARAM_STR, 255);
      $sql->bindParam(':email',$email,PDO::PARAM_STR, 255);
      $sql->bindParam(':amount',$amount,PDO::PARAM_STR, 255);
      $sql->bindParam(':product_info',$productinfo,PDO::PARAM_STR, 255);
      $sql->bindParam(':whatsapp_num',$whatsapp_num,PDO::PARAM_STR, 255);
      $sql->bindParam(':state',$state,PDO::PARAM_STR, 255);
      $sql->bindParam(':branch',$branch,PDO::PARAM_STR, 255);
      $sql->bindParam(':remarks',$remarks,PDO::PARAM_STR, 255);
      $sql->bindParam(':address',$address,PDO::PARAM_STR, 255);
      $sql->bindParam(':pincode',$pincode,PDO::PARAM_STR, 255);
      $sql->bindParam(':paymentpurpose',$paymentpurpose,PDO::PARAM_STR, 255);
      $sql->bindParam(':created',$created,PDO::PARAM_STR, 255);
      $sql->execute();
      $inert_id=$dbo->lastInsertId();
      if($inert_id>0){
        $_SESSION['ins_id']=$inert_id;
        header("Location: payuform.php");
      }
      }
    }
    catch(PDOException $e){
      print "Your fail message: " . $e->getMessage();
    }
  }else{
    $message="Required fields can not be empty";
  }
}
catch(Exception $e){
  print "Your fail message: " . $e->getMessage();
}
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
<style>
    .logo{
      text-align: center;
      padding-left: 35%;
    }
    .error{
      color: red;
    }
</style>

</head>
<body>
<div class="container">
  <div class="row">
    <div class="col-sm-12 col-lg-12 col-md-12 logo ">
      <img  src="image/logopmt.jpg" class="img-responsive"/>
    </div>
  </div>
  <div class="panel panel-primary">
      <div class="panel-heading">Registration & Fee Payment</div>
      <div class="panel-body">
        <?php
        if(isset($message) && $message!=''){
          echo '<h3 style="color:red; text-align:center">'.$message.'</h3>';
        }
         ?>
        <form id="register_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
         <input type="hidden" name="productinfo" value="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua">
          <div class="row">
            <div class="col-sm-12 col-lg-6 col-md-6">
              <div class="form-group">
                <label for="">Name: <span>*</span></label>
                <input type="text" onfocus="clearDefault(this)" name="firstname" id="firstname" class="form-control" placeholder="Fullname" />
              </div>
              <div class="form-group">
                <label for="">Phone: <span>*</span></label>
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">+91</span>
                <input type="text" maxlength="10" class="form-control" onfocus="clearDefault(this)" name="phone" id="phone" placeholder="Phone" aria-describedby="basic-addon1">

              </div>
              <label id="phone-error" class="error" for="phone"></label>
              </div>

              <div class="form-group">
                <label for="">WhatsApp: <span>*</span></label><span id="fill_whatsapp"><label for="whatsapp_num">Same For WhatsApp <input type="checkbox" name="whatsapp_num" id="whatsapp_num"/></label></span>
                <input type="text" maxlength="10" name="whatsapp" id="whatsapp" class="form-control" placeholder="WhatsApp" />
              </div>
              <div class="form-group">
                <label for="">State: <span>*</span></label>
                <input type="text" onfocus="clearDefault(this)" name="state" id="state" class="form-control" onfocus="clearDefault(this)" placeholder="State" />
              </div>
              <div class="form-group">
                <label for="branch">Branch</label>
                <select name="branch" id="branch" class="form-control">
                   <option id="" value="">Select Your Engineering Branch</option>
                  	<option value="CE - Civil Engineering">CE - Civil Engineering</option>
                  	<option value="CH - Chemical Engineering">CH - Chemical Engineering</option>
                  	<option value="CS - Computer Science and Information Technology">CS - Computer Science and Information Technology</option>
                  	<option value="EC - Electronics and Communication Engineering">EC - Electronics and Communication Engineering</option>
                  	<option value="EE - Electrical Engineering">EE - Electrical Engineering</option>
                  	<option value="IN - Instrumentation Engineering">IN - Instrumentation Engineering</option>
                  	<option value="ME - Mechanical Engineering">ME - Mechanical Engineering</option>
                  </select>
              </div>
              <div class="form-group">
                <label for="">Remark</label>
                <input type="text" onfocus="clearDefault(this)" name="remark" id="remark" class="form-control" placeholder="Remark"/>
              </div>

            </div>
            <div class="col-sm-12 col-lg-6 col-md-6">
              <div class="form-group">
              <label>Email: <span>*</span></label>
              <input data-toggle="tooltip" title="Mail will be sent this email" onfocus="clearDefault(this)" placeholder="Email" type="email" pattern="[A-Za-z0-9._%+-]{3,}@[a-zA-Z]{3,}([.]{1}[a-zA-Z]{2,}|[.]{1}[a-zA-Z]{2,}[.]{1}[a-zA-Z]{2,})" class="form-control" name="email" id="email">
              </div>
              <div class="form-group">
                <label>Complete Address: <span>*</span></label>
              <textarea class="form-control" onfocus="clearDefault(this)"  name="address" id="address" placeholder="Complete Address"></textarea>
              </div>
              <div class="form-group pincode_div">
                <label> Pincode : </label>
                <input type="text" placeholder="Pincode" onfocus="clearDefault(this)"  pattern="^(0|[1-9][0-9]*)$" maxlength="6" onkeypress="return isNumberKey(event)" class="form-control" name="pincode" id="pincode" value="" >
            </div>
            <div class="form-group">
            	<label>Payment Purpose:</label>
                 <select name="paymentpurpose" id="paymentpurpose" class="form-control" >
                    <option id="paymentpurpose" value="">Select Your Payment Purpose</option>
            	      <option value="New Admission Classroom--3500">New Admission Classroom</option>
                    <option value="Due Fee Payment Classroom--3500">Due Fee Payment Classroom</option>
            	      <option value="Postal Course & Study Mateterial--3500">Postal Course & Study Mateterial</option>
            	      <option value="Live Classroom Course--3500">Live Classroom Course</option>
                    <option value="Pendrive Video Course--3500">Pendrive Video Course</option>
                    <option value="Book Purchase--3500">Book Purchase</option>
                    <option value="Online Test Series--3500">Online Test Series</option>
                    <option value="C.B.T(computer based test)--3000">C.B.T(computer based test)</option>
            	   </select>
            </div>
            <div class="form-group">
            <label>Amount to Pay: </label> <a href="javascript::void(0)" style="display:none;" id="change_amount">Change Amount</a>
             <input type="text" required="" readonly  pattern="^(0|[1-9][0-9]*)$" class="form-control" onkeypress="return isNumberKey(event)" name="amount" id="amount" placeholder="Amount">

            </div>
            <div class="form-group">
              <label for="">Enter Captcha Code</label>
            <div class="input-group">

              <span class="input-group-addon" id="basic-addon2">18847</span>
              <input type="text" class="form-control" onfocus="clearDefault(this)" name="captcha" id="captcha" placeholder="Enter Captcha Code" aria-describedby="basic-addon1">
            </div>
            <label id="captcha-error" class="error" for="captcha"></label>
            </div>
            </div>
          </div>
          <div class="row text-center">
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="SubmitButton" value="Register">
            </div>
          </div>
        </form>
      </div>
    </div>
</div>
<script>
function clearDefault(event){
  $(event).val('');
}
function isNumberKey(evt)
  {
     var charCode = (evt.which) ? evt.which : event.keyCode
     if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

     return true;
  }
  $(document).ready(function(){
    var num = Math.floor(Math.random() * 90000) + 10000;
    $("#basic-addon2").text(num);
    $("#email").on('keypress',function(){
      $('[data-toggle="tooltip"]').tooltip();
    })

    $("#fill_whatsapp").on('click',function(){
      var phone=$("#phone").val();
      var checked=$("#whatsapp_num").is(":checked");
      if(phone==''){
        alert('Please Enter Phone Number');
         $("#whatsapp_num").prop("checked", false);
      }else if(phone.length<10){
        alert('Please Enter Valid Phone Number');
         $("#whatsapp_num").prop("checked", false);
      }else if(!checked){
        $("#whatsapp").val('');
      }else{
        $("#whatsapp").val(phone);
      }
    });
    $("#paymentpurpose").on('change',function(){
      var purpose=$(this).val();
      var amtVal=purpose.split('--');
      if(!isNaN(parseInt(amtVal[1]))){
        $("#amount").val(parseInt(amtVal[1]));
        $("#change_amount").css({"display":"inline"});
      }else{
        $("#amount").val('');
        $("#change_amount").css({"display":"none"});
      }

    })
    $("#change_amount").on('click',function(){
      $("#amount").removeAttr('readonly');
    })
  });
</script>
<script src="js/jquery.validate.js"></script>
<script src="js/custom_validate.js"></script>
</body>
</html>
