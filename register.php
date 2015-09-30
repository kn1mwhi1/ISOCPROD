<html>
<head>
<?php 
require_once 'lib/Class_LoginLogic.php'; 
$TierTwo = new LoginLogic();
try
{
	$TierTwo->checkSession();
	$TierTwo->checkPOSTRegisterInfo();
	
}
catch (Exception  $e)
{
	echo $e->getMessage() ;
}
?>
<script type="text/javascript" src="script/bootstrap.js"></script>
<script type="text/javascript" src="script/jquery.js"></script>
<script type="text/javascript" src="script/sweetalert.min.js"></script>
<script type="text/javascript" src="script/cookies.js"></script>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="css/sweetalert.css" />
<link rel="stylesheet" type="text/css" href="css/errorCSS.css" />
<script>
loadCookies();
</script>

<script>
// Uses HTML5 features to save local info from username and password to local computer.

          
// function to show calendar 2

			




/*			try
{

			
                   $('#username').val(localStorage['username']);
					$('#nameID').val(localStorage.['nameID']);
					$('#firstname').val(localStorage['firstname']);
					$('#lastname').val(localStorage['lastname']);
					$('#passwd').val(localStorage.['passwd']);
					$('#secretWord').val(localStorage['secretWord']);
}
catch (Exception e)
{
	alert(e);

}		
	
*/
						
        

 </script>

</head>
<body>

 <div class="container">    
        <div id="signupbox" style="margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Sign Up</div>
                            <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="login.php">Sign In</a></div>
                        </div>  
                        <div class="panel-body" >
<!-- Register Form -->						
                            <form id="signupform" class="form-horizontal" role="form" method="post" action="">
                                
                                <div id="signupalert" style="display:none" class="alert alert-danger">
                                    <p>Error:</p>
                                    <span></span>
                                </div>
                                    
                                
                                  
                                <div class="form-group">
                                    <label for="email" class="col-md-3 control-label">Email</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control <?php $TierTwo->getError('email');?>" id="username" name="email" placeholder="Email Address">
                                    </div>
                                </div>
								
								 <div class="form-group">
                                    <label for="id" class="col-md-3 control-label">Employee ID</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control <?php $TierTwo->getError('id');?>" id="nameID" name="id" placeholder="Employee ID">
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <label for="firstname" class="col-md-3 control-label">First Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control <?php $TierTwo->getError('firstname');?>" id="firstname" name="firstname" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="lastname" class="col-md-3 control-label">Last Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control <?php $TierTwo->getError('lastname');?>" id="lastname" name="lastname" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="passwd" class="col-md-3 control-label">Password</label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control <?php $TierTwo->getError('passwd');?>" id="passwd" name="passwd" placeholder="Password">
                                    </div>
                                </div>
								
								<div class="form-group">
                                    <label for="secretWord" class="col-md-3 control-label">Secret Word</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control <?php $TierTwo->getError('secretWord');?>" id="secretWord" name="secretWord" placeholder="Secret Word"  >
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <!-- Button -->                                        
                                    <div class="col-md-2 col-md-offset-5">
                                        <input class="btn btn-success" type="submit" id='btn-register' value='Register'>
                                    </div>
                                </div>
                            </form>
                         </div>
                    </div>

               
               
                
         </div> 
    </div>
	<script>




	
	$('#username').val( localStorage['username'] );
	$('#nameID').val( localStorage['nameID'] );
	$('#firstname').val( localStorage['firstname'] );
	$('#lastname').val( localStorage['lastname'] );
	$('#passwd').val( localStorage['passwd'] );
	$('#secretWord').val( localStorage['secretWord'] );
	
	
	
	
$(document).on('click', '#btn-register', function () {

						localStorage['username'] = $('#username').val();
						localStorage['nameID'] = $('#nameID').val();
						localStorage['firstname'] = $('#firstname').val();
						localStorage['lastname'] = $('#lastname').val();
						localStorage['passwd'] = $('#passwd').val();
						localStorage['secretWord'] = $('#secretWord').val();
						
						
						
						
});
       

</script>
	
	
 <?php 
$TierTwo->notifyMessage();
?>
</body>



</html>