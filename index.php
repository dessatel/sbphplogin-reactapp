<!DOCTYPE html>
<html lang="en">
 <!-- THIS FILE SHOULD NOT BE USED ANYMORE NEW FILE is snuiapp/login.html -->
<head>
    <link rel="stylesheet" href="../sbuiauth/styles.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Streambox Login</title>
</head>

<body>
    <!-- <form action="auth.php"> -->
    <div class="outer-grid">
        <div class="container">
            <img class="logo" src="../sbuiauth/streambox-logo.svg" />
            <div class="grid">
                <label for="username">Username:</label>
                <input id="username-box" name="username" type="text" />
            </div>
            <div class="grid">
                <label for="password">Password:</label>
                <input id="password-box" name="password" type="password" />
            </div>
            <!-- <input type="submit" /> -->
            <button class="btn" onclick="authenticate()">Submit</button>
            <div id="invalid-pass-div"></div>
        </div>
    </div>
    <!-- </form> -->
    <footer>
        Powered by Streambox, Inc. All rights reserved Version 1.14
    </footer>
</body>
</html>

<script type="text/javascript" language="javascript" src="../REST/inc/jquery.min.js"></script>
<script type="text/javascript">

function SendCommandCustom(c, callback, url, onfail){
	var params = "c="+encodeURIComponent(c);
	if (onfail)
		$.post(url, params, callback).fail(onfail);
	else
		$.post(url, params, callback);
}    



function makePwdUneditable()
{
    // print to console
}


function logout(){
	var r = {
		"command"    :"logout"
	}
	SendCommandCustom(JSON.stringify(r), onReload, "../REST/sys/autsys/auth");
}

 async function authenticate() {
        const username = document.getElementById("username-box").value
        const password = document.getElementById("password-box").value
         /// Standard Chroma Authentication API
        var r = {
		    "command":  "auth"
		    ,"userID":  username
		    ,"pwd"   :  password
	    }
        
	    SendCommandCustom(JSON.stringify(r), onAuth, "../REST/sys/auth", onAuthFailed );
}

function onAuthFailed(xmlHttp, textStatus, errorThrown ){
        document.getElementById("invalid-pass-div").textContent = "Username or password is incorrect"
}
    
function onAuth(data, textStatus, xmlHttp){
        makePwdUneditable(0);
        if (!data){
            document.getElementById("aa").innerHTML = "error?" ;
            return;
        }
        switch(data.result_code){
            case 0:
                // login success !
                window.location = `${location.origin}/sbuiapp`
                break;
            default:
                //document.getElementById("invalid-pass-div").textContent = "Username or password is incorrect"
                alert("ERR?? " + data.result_code + " " + data.message);
                break;
        }   
    }

   
</script>