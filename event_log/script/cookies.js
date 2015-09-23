function setCookie(NameOfCookie, value, expiredays)
{ 
	
		var ExpireDate = new Date ();
		ExpireDate.setTime(ExpireDate.getTime() + (expiredays * 24 * 3600 * 1000));
		document.cookie = NameOfCookie + "=" + value + ((expiredays == null) ? "" : "; expires=" + ExpireDate.toGMTString());
		window.status="Your information has been saved.";

}


// Single delete of a cookie , input is the name of the cookie
function delCookie(NameOfCookie) 
{ 
	if (getCookie(NameOfCookie)) 
	{
		document.cookie = NameOfCookie + "=" + "; expires=Thu, 01-Jan-70 00:00:01 GMT";
	}
}


function getCookie(name)
  {
    var nothing = '';
	var re = new RegExp(name + "=([^;]+)");
    var value = re.exec(document.cookie);
    return (value != null) ? unescape(value[1]) : null ;
  }


//
function loadCookies()
{
document.getElementById('loginusername').value = getCookie("loginusername");
document.getElementById('loginpassword').value = getCookie("loginpassword");
document.getElementById('loginremember').checked  = getCookie("loginremember");
}



