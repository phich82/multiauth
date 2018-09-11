$(document).ajaxError(function (event, jqxhr, settings, error) {
    alert("Session expired. You'll be take to the login page!");
    console.log(event, jqxhr, settings, error);
    //location.href = "/login";
});
