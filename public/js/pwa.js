
console.log("Dabotap Security Framework v1.01");

var dabotap = {
	user: false,
	terrorists: false,
	view: 'splash',
	status: 'loading',
};

var buttons = new Array();


function _setBackView(current,back){
    for(var i=0; i<buttons.length; i++)
    {
        if(buttons[i][0] == current)
        {
            buttons[i][1] = back;
            return true;
        }
    }
    var view = new Array(current,back);
    buttons[buttons.length] = view;
}

function updateBackButton(name){
    //console.log("Updating back button");
    closeNav();
    var updated = false;
    for(i = 0; i<buttons.length; i++)
    {
        if(buttons[i][0] == name)
        {
            updated = true;
            $('#backButton').attr('name',buttons[i][1]);
        }
    }

    if(updated)
        $('#backButton').removeClass('hidden');
    else
        $('#backButton').addClass('hidden');
}


function logout(){

    _showView('splash');

	$.ajax({
        type: 'GET',
        url: '/logout',
        data: { },
        success: function(response) {
            
            notify("You have been logged out");
            dabotap.user = false;

            setTimeout(function(){
                location.reload();
            },1019);

            

            
                
        },
        error: function() {
            
            error('Logout failed. Check your internet connection');
            _showView('deals');
            
        },
    });
}

function validate(category,value){
    var result = false;
    if(category == "email")
    {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if(re.test(value))
        {
            result = true;
        }
    }
    if(category == 'user-name')
    {
        var re = /^[a-zA-Z ]+$/
        if(re.test(value))
            result = true;
    }
    if(category == 'link')
    {
        var re = /(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
        if(re.test(value))
            result = true;
    }
    if(category == 'phone')
    {
        //var re = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im
        var re = /^0[0-8]\d{8}$/g;
        if(re.test(value))
            result = true;
    }

    if(category == 'date')
    {
        if(value == "Invalid Date")
            return false;
        return true;
    }

    return result;
}

function _getToken(){

	return $('#meta-csrf').attr('content');
}

function _setToken(t){
	console.log("csrf set to: " + t);
	$('#meta-csrf').attr('content',t);
}

function _showView(name){
	console.log("Showing view "+name);

	$('.application-view').each(function(){
		if($(this).attr('name') == name)
			$(this).removeClass('hidden');
		else
			$(this).addClass('hidden');
	});

	$('.application-footerTab').each(function(){
		if($(this).attr('name') == name)
			$(this).children('i').addClass('active');
		else
			$(this).children('i').removeClass('active');
	});

    updateBackButton(name);

    dabotap.view = name;

	return true;
}

function _goToPage(page){
	switch(page)
	{
		case "logout":
			return logout();
			break;

        case "admin":
            if(dabotap.user.role == "admin")
            {

                window.location = '/admin/home';
                return;
            }
            error("Admin section is restricted");

            break;

		default:
			return showView(page);
	}
}


function _refreshUser(){
	$.ajax({
        type: 'POST',
        url: '/api/profile',
        data: {_token:_getToken(), },
        success: function(user) {
                            
            
            dabotap.user = user;
			console.log('User refreshed');

            var $p = ''+
            '<img src="images/profiles/'+user.avatar+'" title="change">'+
            '<div class="profile-details">'+
                '<h5>'+user.name+'</h5>'+
                '<p>@'+user.username+'</p>'+
                '<button class="btn btn-sm btn-info" id="editProfile">edit profile</button><br><br>'+
            '</div>';

            $('.profile-header').children().remove();
            $('.profile-header').append($p);

            $('#editProfile').click(function(){
                $('#editProfileName').val(dabotap.user.name);
                $('#editProfilePhone').val(dabotap.user.phone);
                showView("editProfile");
            });

            $('.profile-header').children('img').click(function(){
                $('#profileImageUploader').click();
            });

            if(dabotap.user.role == "admin")
            {
                $('.openAdmin').removeClass('hidden');
            }
            
                
        },
        error: function() {
            
            console.log('Couldnt refresh your profile');
            
        },
    });
}

function updateProfileImage(){
    console.log("Image uploading");
    $('#profileImageToken').val(_getToken());
    $('#profileImageForm').ajaxForm({
        success: function(res,status,xhr,form){
            if(res == 0)
            {
                notify("Profile image updated");
                _refreshUser();
            }
            else
            {
                error('Something happened. Please try again');
            }
            
            
        },
        error: function(err,err1,err3){
            error('Failed to update profile image');
            console.log(err,err1,err3);

        }
    }).submit();
}

function updateProfile(){
    var name = $('#editProfileName').val();
    var phone = $('#editProfilePhone').val();

    if(!validate('user-name',name))
    {
        error("Invalid name!");
        return;
    }

    if(!validate('phone',phone))
    {
        error("Invalid phone number!");
        return;
    }
    
    $.ajax({
        type: 'POST',
        url: '/api/updateProfile',
        data: {_token:_getToken(), name: name, phone: phone },
        success: function(res) {
                            
            
            if(res == 0)
            {
                _refreshUser();
                notify("Profile updated");
                showView("profile");
            }
            else
            {
                error("Something happened. Please try again");
            }

                
        },
        error: function() {
            
            error('Couldnt update your profile');
            
        },
    });
}

function clearContactUsForm(){
    $('#contactUsName').val('');
    $('#contactUsPhone').val('');
    $('#contactUsMessage').val('');
    console.log("Contact form cleared");
}

function contactUs(){

    var name = $('#contactUsName').val();
    var email = $('#contactUsEmail').val();
    var message = $('#contactUsMessage').val();


    if(!validate("user-name",name))
    {
        error("Invalid name provided");
        return;
    }

    if(!validate("email",email))
    {
        error("Invalid e-mail address");
        return;
    }

    if(message.length <100)
    {
        error("Expound the message. Minimum 100 characters");
        return;
    }

    $('#contactUsToken').val(_getToken());

    $('#contactUsForm').ajaxForm({
        success: function(res,status,xhr,form){
            if(res == 0)
            {
                notify("We have received your message");
                clearContactUsForm();
                showView("about");
            }
            else
            {
                error('An error occurred while sending your message');
            }
            
            
        },
        error: function(err,err1,err3){
            error('Failed to send message!');
            console.log(err,err1,err3);

        }
    }).submit();
}

function _watchTower(){
	var $contents = ''+
	'<div class="users-header">'+
		'<h5>Baraka Phase 10</h5>'+
	'</div>'+
	'<div class="users-body" id="message-feed">'+
		'<p class="message message-in" message_id="" user_id="">Baraka Phase 10 <br><span>x mins ago</span></p>'+
		'<p class="message message-out" message_id="" user_id="">Baraka Phase 10 <br><span>x mins ago</span></p>'+
		'<p class="message message-in" message_id="" user_id="">Baraka Phase 10 <br><span>x mins ago</span></p>'+
		'<p class="message message-out" message_id="" user_id="">Baraka Phase 10 <br><span>x mins ago</span></p>'+
		'<p class="message message-in" message_id="" user_id="">Baraka Phase 10 <br><span>x mins ago</span></p>'+
		'<p class="message message-out" message_id="" user_id="">Baraka Phase 10 <br><span>x mins ago</span></p>'+
		'<p class="message message-in" message_id="" user_id="">Baraka Phase 10 <br><span>x mins ago</span></p>'+
		'<p class="message message-out" message_id="" user_id="">Baraka Phase 10 <br><span>x mins ago</span></p>'+
		'<p class="message message-in" message_id="" user_id="">Baraka Phase 10 <br><span>x mins ago</span></p>'+
		'<p class="message message-out" message_id="" user_id="">Baraka Phase 10 <br><span>x mins ago</span></p>'+
		'<p class="message message-in" message_id="" user_id="">Baraka Phase 10 <br><span>x mins ago</span></p>'+
		'<p class="message message-out" message_id="" user_id="">Baraka Phase 10 <br><span>x mins ago</span></p>'+
		'<p class="message message-in" message_id="" user_id="">Baraka Phase 10 <br><span>x mins ago</span></p>'+
		'<p class="message message-out" message_id="" user_id="">Baraka Phase 10 <br><span>x mins ago</span></p>'+
		'<p class="message message-in" message_id="" user_id="">Baraka Phase 10 <br><span>x mins ago</span></p>'+
		'<p class="message message-out" message_id="" user_id="">Baraka Phase 10 <br><span>x mins ago</span></p>'+
		'<p class="message message-in" message_id="" user_id="">Baraka Phase 10 <br><span>x mins ago</span></p>'+
		'<p class="message message-out" message_id="" user_id="">Baraka Phase 10 <br><span>x mins ago</span></p>'+

	'</div>'+
	'<div class="users-footer">'+
		'<input type="text" maxlength="140" id="compose" class="form-control" autofocus="autofocus" placeholder="Type and press enter to send"/>'+
	'</div>';

	$('.users').append($contents);
	console.log('Watch Tower Ready');

	$('.users-body').height(window.innerHeight * 0.65);

	
}

function _terrorList(){
	$.ajax({
        type: 'POST',
        url: '/api/load-terrorists',
        data: {_token:_getToken(), },
        success: function(terrorists) {
                            
            
            dabotap.terrorists = terrorists;
			console.log('Terrorists loaded');

			var $contents = ''+
			'<h4>WANTED SUSPECTS</h4>'+
			'<div class="terrorist" terrorist_id="">'+
				'<img src="images/profiles/avatar.jpg" />'+
				'<h6>Someone Someone</h6>'+
				'<p>Armed and dangerous</p>'+
			'</div>'+
			'<div class="terrorist" terrorist_id="">'+
				'<img src="images/profiles/avatar.jpg" />'+
				'<h6>Someone Someone</h6>'+
				'<p>Armed and dangerous</p>'+
			'</div>'+
			'<div class="terrorist" terrorist_id="">'+
				'<img src="images/profiles/avatar.jpg" />'+
				'<h6>Someone Someone</h6>'+
				'<p>Armed and dangerous</p>'+
			'</div>';

			$('.terror').children().remove();
			$('.terror').append($contents);

            
            
                
        },
        error: function() {
            
            console.log('Couldnt load terrorists');
            
        },
    });
}

function _telephoneWatch(){
	//prepare the telephone view

	//quick links to call police, an active group member, estate manager, 
	//links to capture image/video or upload image/video to exposed pool
	//link to record audio and send to exposed pool
	//link to message group members

	var $contents = ''+
	'<h5 class="middle">The Big Brother</h5>'+
	'<br><div class="telephone-quick">'+
		'<a class="telephone-police" href="tel://999">'+
			'<i class="fa fa-car"/> <br>Call Police'+
		'</a>'+
		'<a class="telephone-hosi" href="tel://999">'+
			'<i class="fa fa-heart"/> <br> Ambulence'+
		'</a>'+
		'<a class="telephone-help goToPage" href="tel://911">'+
			'<i class="fa fa-users"/> <br> Request help'+
		'</a>'+
	'</div>'+
	'<br style="clear:both">'+
	'<hr>'+
	'<div class="telephone-exposed">'+
		'<h6>Use this panel to send tips to intelligence</h6>'+
		'<br style="clear:both">'+		
		'<button class="btn btn-sm btn-primary">Send Media <i class="fa fa-camera"/></button>'+
		'<button class="btn btn-sm btn-success">Send Audio <i class="fa fa-microphone"/></button>'+
		'<br style="clear:both">'+
		'<br style="clear:both">'+
		'<br style="clear:both">'+
		'<textarea class="form-control" placeholder="Type and press enter to send"></textarea>'+
		'<br style="clear:both">'+

		'<hr>'+
	'</div>';

	$('.telephone').append($contents);
	console.log('telephone Ready');

}

function authenticated(){
	if(dabotap.user == false)
	{
		$('#application-footer').addClass('hidden');
		return false;
	}
	$('#application-footer').removeClass('hidden');
	return true;
}

function showView(name){

    if(dabotap.view == name)
    {
        console.log("View change aborted");
        return false;
    }
    
	switch(name){

        
		case "home":
			if(!authenticated())
			{
				return	showView('login');
			}
			$('#application-footer').removeClass('hidden');
			return _showView(name);
			break;

        case "rides":
            if(!authenticated())
            {
                return  showView('login');
            }
            $('#application-footer').removeClass('hidden');
            return _showView(name);
            break;

        

		case "login":
			if(authenticated())
			{
				return	showView('home');
			}
			return _showView(name);
			break;

        case "register":
            if(authenticated())
            {
                return  showView('home');
            }
            return _showView(name);
            break;

        case "admin":
            if(authenticated() && dabotap.user.role == 'admin')
            {
                return  window.location = '/';
            }
            else
            {
                error("Unauthorised access");
                return _showView('profile');
            }
            
            break;

		default:
			_showView(name);
	}
}

function notify(message){
    console.log("Notification: " + message);
    $.notify(message,"success");
}
function error(message){
    console.log("Error: " + message);
    $.notify(message);
}







function startApp(){


    $.ajax({
        type: 'GET',
        url: 'api/csrf',
        data: {_token:_getToken() },
        success: function(csrf) {

            console.log("csrf token loaded");
            
            _setToken(csrf);
            _refreshUser();
            _telephoneWatch();
            _watchTower();
            _terrorList();
            
            setInterval(_refreshUser,15000);
            setInterval(_terrorList,60000);

            setTimeout(showView,1019,'home');
            //showView('home');

        },
        error: function() {
            
            error('Failed to start application');
            
        },
    });

    
}





function _boot(){
	console.log("Dabotap booting...");

	$.ajax({
        type: 'POST',
        url: '/api/authenticated',
        data: {_token:_getToken(), },
        success: function(auth) {
            
            if(auth == 0)
            {

            	console.log("Authenticated user found");
            	startApp();
            	

                _setBackView('editProfile','profile');

            }
            else
            {
                setTimeout(showView,1019,"login");
            	//showView('login');
            }
        },
        error: function() {
            
            notify('Couldnt load your profile');
            showView('login');
            
        },
    });	
}


_boot();










$('.goToPage').click(function(){

	var page = $(this).attr('name');
    console.log("Going to page: " + page);

	_goToPage(page);
});

$('#tryLogin').click(function(){

    var usernme = $('#loginName').val();
    var password = $('#loginPassword').val();

    if(!validate("user-name",usernme))
    {
        error("Invalid Username");
        return;
    }

	if(password.length <6)
	{
		error("Invalid password");
		return;
	}

    $('#tryLogin').parent().addClass('hidden');
    $('#loginText').removeClass('hidden');

    //$('#loginCSRF').val(_getToken());

    //return $('#loginForm').submit();

    return $("#loginForm").ajaxForm({
        success: function(res,status,xhr,form){
            notify("Login success");
            $('#loginPassword').val('');
            startApp();
        },
        error: function(err,err1,err3){
            $('#loginPassword').val('');
            error('Login Failed! Please try again');
            $('#tryLogin').parent().removeClass('hidden');
            $('#loginText').addClass('hidden');
            console.log(err,err1,err3);

        }
    }).submit();
    

    $('#loginText').removeClass('hidden');
    $('#tryLogin').addClass('hidden');

	$.ajax({
        type: 'POST',
        url: '/login',
        data: {_token: _getToken(), email: email, password: password },
        success: function(response) {
            $('#loginPassword').val('');
            notify("Login success");

            startApp();
            
                
        },
        error: function() {
            $('#loginPassword').val('');
            error('Login Failed! Please try again');
            $('#tryLogin').removeClass('hidden');
            $('#loginText').addClass('hidden');
            
        },
    });		
});

$('#tryRegister').click(function(){

    var name = $('#registerName').val();
    var email = $('#registerEmail').val();
    var gender = $('#registerGender').val();
    var password = $('#registerPassword').val();
    //var _password = $('#registerPasswordConfirmation').val();

    if(!validate("user-name",name))
    {
        error("Invalid Name");
        return;
    }

    if(!validate("email",email))
    {
        error("Invalid E-mail address");
        return;
    }

    if(gender == 0)
    {
        error("Gender not selected");
        return 0;
    }

    if(password.length <6)
    {
        error("Password is invalid");
        return;
    }

    //
    $('#registerPasswordConfirmation').val(password);

    $('#registerText').removeClass('hidden');
    $('#tryRegister').addClass('hidden');

    //return $("#registerForm").submit();

    $("#registerForm").ajaxForm({
        success: function(res,status,xhr,form){
            $('#registerPassword').val('');
            notify("Registration successful");
            startApp();
        },
        error: function(a,b,c){
            $('#registerPassword').val('');

            console.log(a,b,c);

            error("Registration failed. Please try again later");
            setTimeout(function(){
                $('#registerText').addClass('hidden');
                $('#tryRegister').removeClass('hidden');
            },500);
            

        }
    }).submit();   
});
