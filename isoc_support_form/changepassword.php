<html>
<head>
<?php 
require_once 'lib/Class_LoginLogic.php'; 
$TierTwo = new LoginLogic();
?>
<script type="text/javascript" src="script/bootstrap.js"></script>
<script type="text/javascript" src="script/jquery.js"></script>
<script type="text/javascript" src="script/sweetalert.min.js"></script>
<script type="text/javascript" src="script/cookies.js"></script>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="css/sweetalert.css" />
<link rel="stylesheet" type="text/css" href="css/errorCSS.css" />
<link rel="stylesheet" type="text/css" href="css/customCss.css" />
<script>
loadCookies();
</script>

<?php
try
{
	$TierTwo->checkSessionLoginRegister();
	$TierTwo->checkPOSTLoginInfo();
}
catch (Exception  $e)
{
	echo $e->getMessage() ;
}
?>

</head>

 <div class="container">    
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title">Change Password</div>
                        <div style="float:right; font-size: 80%; position: relative; top:-10px">
						
							<a href="login.php">Log In</a>
							
						</div>
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
<!-- Beginning of login Form -->
                            
                        <form id="loginform" class="form-horizontal" role="form" method="post" action="" >
                                    
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input id="loginusername" type="text" class="form-control <?php $TierTwo->getError('username');?>"  name="username" placeholder="employee id or email" onblur="setCookie('loginusername', document.getElementById('loginusername').value ,365);">                                        
                                    </div>
                                
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="currentPassword" type="password" class="form-control <?php $TierTwo->getError('currentPassword');?>" name="currentPassword" placeholder="Current Password" onblur="setCookie('loginpassword', document.getElementById('loginpassword').value ,365);">
                                    </div>
                                    
									<div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="newPassword" type="password" class="form-control <?php $TierTwo->getError('newPassword');?>" name="newPassword" placeholder="New Password" onblur="setCookie('loginpassword', document.getElementById('loginpassword').value ,365);">
                                    </div>
									
									<div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="confirmPassword" type="password" class="form-control <?php $TierTwo->getError('newPassword');?>" name="confirmPassword" placeholder="Confirm Password" onblur="setCookie('loginpassword', document.getElementById('loginpassword').value ,365);">
                                    </div>

                                
                            <div class="input-group">

                                    </div>


                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->

                                    <div class="col-sm-12 controls">
 <!-- Submit button -->            
										<input class="btn btn-primary" type="submit" id='btn-login' value='Change'>
										<!--<a class="btn btn-danger right" href="logout.php">Log Out</a> -->
                                    </div>

                                </div>


                                <div class="form-group">
                                    <div class="col-md-12 control">
                                        <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                            Don't have an account! 
                                        <a href="register.php">
                                            Sign Up Here
                                        </a>
                                        </div>
                                    </div>
                                </div>    
                            </form>   


<!-- End of login Form --->							



                        </div>                     
                    </div>  
        </div>
    </div>
 <?php 
$TierTwo->notifyMessage();
?>
</html>