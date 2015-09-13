// get time function that calls time 



function getDateTime()
{
	var timeNow = new Date();
    var year = timeNow.getFullYear();
    var day = timeNow.getDay();
    var month = timeNow.getMonth() + 1; 
    var hours   = timeNow.getHours();
    var minutes = timeNow.getMinutes();
    var timeString = ( month < 10) ? "0" + month + "/" : month + "/";
   
    timeString += (day < 10 ) ? "0" + day + "/" : day + "/" ;
    timeString += year + " ";
    timeString += "" + ((hours > 12) ? hours - 12 : hours);
    timeString += ((minutes < 10) ? ":0" : ":") + minutes;
    timeString += (hours >= 12) ? " PM" : " AM";

	return timeString;
document.getElementById('getDateTime').value = today;
}