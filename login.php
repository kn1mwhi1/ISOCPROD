<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<?php 
require_once 'lib/Class_LoginLogic.php'; 
$TierTwo = new LoginLogic();
?>
<script type="text/javascript" src="script/bootstrap.js"></script>
<script type="text/javascript" src="script/jquery.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript" src="script/sweetalert.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="css/sweetalert.css" />


<script>
loadCookies();
</script>

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


<script>
// Uses HTML5 features to save local info from username and password to local computer.

            $(function() {

                if (localStorage.chkbx && localStorage.chkbx != '') {
                    $('#loginremember').attr('checked', 'checked');
                    $('#username').val(localStorage.usrname);
                    $('#loginpassword').val(localStorage.pass);
                } else {
                    $('#loginremember').removeAttr('checked');
                    $('#username').val('');
                    $('#loginpassword').val('');
                }

                $('#loginremember').click(function() {

                    if ($('#loginremember').is(':checked')) {
                        // save username and password
                        localStorage.usrname = $('#username').val();
                        localStorage.pass = $('#loginpassword').val();
                        localStorage.chkbx = $('#loginremember').val();
                    } else {
                        localStorage.usrname = '';
                        localStorage.pass = '';
                        localStorage.chkbx = '';
                    }
                });
            });
			
			
			
			
			
			

 </script>


</head>
<body>


 <div class="container">    
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title">Sign In</div>
                        <div style="float:right; font-size: 80%; position: relative; top:-10px">
						
						</div>
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
<!-- Beginning of login Form -->
                            
                        <form id="loginform" class="form-horizontal" role="form" method="post" action="login.php" >
                                    
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input id="username" type="text" class="form-control <?php $TierTwo->getError('username');?>"  name="username" placeholder="employee id or email" >                                        
                                    </div>
                                
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="loginpassword" type="password" class="form-control <?php $TierTwo->getError('password');?>" name="password" placeholder="password" >
                                    </div>
                                    

                                
                            <div class="input-group">
                                      <div class="checkbox">
                                        <label>
                                          <input id="loginremember" type="checkbox" name="remember" > Remember me
                                        </label>
                                      </div>
                                    </div>


                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->

                                    <div class="col-sm-12 controls">
 <!-- Submit button -->            
										<input class="btn btn-primary" type="submit" id='btn-login' value='Login' href="login.php">
										<a class="btn btn-danger right" href="login.php?logout=true">Log Out</a>
                                    </div>

                                </div>


                                <div class="form-group">
                                    <div class="col-md-12 control">
                                        <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                     Create an Account for another ISOC Tech (Must be logged in first)! 
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

   

    </body>    


</html>