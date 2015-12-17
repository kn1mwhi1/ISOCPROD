<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<?php 
require_once 'lib/Class_LoginLogic.php'; 
$TierTwo = new LoginLogic();
?>



	<!-- Load CSS --> 
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" /> 
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" /> 
	<link rel="stylesheet" type="text/css" href="css/sweetalert.css" />	
	<link rel="stylesheet" type="text/css" href="css/shiftlog.css" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.css" />
	
	
	<!-- Load Javascript -->
	<script type="text/javascript" src="script/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="script/bootstrap.min.js"></script>
	<script type="text/javascript" src="script/moment-with-locales.js"></script>
	<script type="text/javascript" src="script/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="script/getdatetime.js"></script>
	<script type="text/javascript" src="script/editAccount.js"></script>

<?php
try
{
	$TierTwo->checkSessionLogin();
	$TierTwo->getNavBar();
	$TierTwo->checkPOSTLoginInfo();
}
catch (Exception  $e)
{
	echo $e->getMessage() ;
}
?>





</head>
<body>
<div class="container">
    <h1>Edit Account Information</h1>
  	<hr>
	<div class="row">

      
      <!-- edit form column 
      <div class="col-md-9 personal-info">
        <div class="alert alert-info alert-dismissable">
          <a class="panel-close close" data-dismiss="alert">×</a> 
     
          This page is under construction and does not work yet.
        </div>
		-->
		
        <h3>Personal info</h3>
		<form class="form-horizontal" role="form">
        
		<div class="form-group adminUserPicker">
             <label class="col-lg-3 control-label">Choose User:</label>
			   <div class="col-lg-8">
				<select class="form-control adminSelect" name="adminSelect" id="adminSelect"  style="">
					<?php $TierTwo->createDropDownListAllTechs(); ?>
				</select>
			
             </div>
          </div>
		  
        
          <div class="form-group">
            <label class="col-lg-3 control-label">First name:</label>
            <div class="col-lg-8">
              <input class="form-control firstName" type="text" value="" onblur="validation( this, 'ALL' );">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Last name:</label>
            <div class="col-lg-8">
              <input class="form-control lastName" type="text" value="" onblur="validation( this, 'ALL' );">
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-3 control-label">Email:</label>
            <div class="col-lg-8">
              <input class="form-control email" type="text" value="" onblur="validation( this, 'ALL' );">
            </div>
          </div>
		  
		  <div class="form-group">
            <label class="col-lg-3 control-label">Secret Word:</label>
            <div class="col-lg-8">
              <input class="form-control secretWord" type="text" value="" onblur="validation( this, 'ALL' );">
            </div>
          </div>
		  
		  <!--
          <div class="form-group">
            <label class="col-lg-3 control-label">Time Zone:</label>
            <div class="col-lg-8">
              <div class="ui-select">
                <select id="user_time_zone" class="form-control">
                  <option value="Hawaii">(GMT-10:00) Hawaii</option>
                  <option value="Alaska">(GMT-09:00) Alaska</option>
                  <option value="Pacific Time (US &amp; Canada)">(GMT-08:00) Pacific Time (US &amp; Canada)</option>
                  <option value="Arizona">(GMT-07:00) Arizona</option>
                  <option value="Mountain Time (US &amp; Canada)">(GMT-07:00) Mountain Time (US &amp; Canada)</option>
                  <option value="Central Time (US &amp; Canada)" selected="selected">(GMT-06:00) Central Time (US &amp; Canada)</option>
                  <option value="Eastern Time (US &amp; Canada)">(GMT-05:00) Eastern Time (US &amp; Canada)</option>
                  <option value="Indiana (East)">(GMT-05:00) Indiana (East)</option>
                </select>
              </div>
            </div>
          </div>  
		 
          <div class="form-group">
            <label class="col-md-3 control-label">Username:</label>
            <div class="col-md-8">
              <input class="form-control" type="text" value="janeuser">
            </div>
          </div>
		   -->
		   
		  <div class="form-group">
             <label class="col-lg-3 control-label">Role:</label>
			   <div class="col-lg-8">
				<select class="form-control role-select" name="role" id="role"  style="">
				  <option value="User">User</option>
				  <option value="Admin">Admin</option>
				</select>
				<input class="form-control role-text" type="text" value="">
             </div>
          </div>
		  
		  <div class="form-group">
             <label class="col-lg-3 control-label">Shift:</label>
			   <div class="col-lg-8">
				<select class="form-control shift" name="shift" id="shift"  style="">
				  <option value="1">1st</option>
				  <option value="2">2nd</option>
				  <option value="3">3rd</option>
				  <option value="Cross Shift">Cross Shift</option>
				  <option value="Unix">Unix</option>
				</select>
			
             </div>
          </div>
		  <div class="form-group">
            <label class="col-lg-3 control-label">Employee ID:</label>
            <div class="col-lg-8">
              <input class="form-control id" type="text" value="" onblur="validation( this, 'ALL' );">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">Password:</label>
            <div class="col-md-8">
              <input class="form-control password1" type="password" value="" onblur="validation( this, 'SANITIZE' );">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label ">Confirm password:</label>
            <div class="col-md-8">
              <input class="form-control password2" type="password" value="" onblur="validation( this, 'SANITIZE' );">
            </div>
          </div>
		  </form>
		  
		  <!-- Buttons -->
          <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8">
              <input type="submit" class="btn btn-primary save" value="Save Changes">
              <span></span>
              <input type="reset" class="btn btn-default clear" value="clear">
            </div>
          </div>
        
		
		
		
      </div>
  </div>
</div>


<hr>



 <?php 
$TierTwo->notifyMessage();
?>

   

    </body>    


</html>