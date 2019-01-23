<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dabotap Security Framework</title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="Find a salon near you" />
        <meta name="csrf-token" id="meta-csrf" content="{{ csrf_token() }}">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-mobile-web-app-title" content="Dabotap">

        <link rel="icon" href="images/logo100.png">
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" media="none" onload="if(media!='all')media='all'">
        <link href="css/fontawesome-all.min.css" rel="stylesheet" type="text/css" media="all">
        <link rel="apple-touch-icon" href="images/logo100.png">
        <link href="css/grt-custom.css" rel="stylesheet" type="text/css" media="all">
        <link href="css/pwa.css" rel="stylesheet" type="text/css" media="all">
        <link href="css/overlay.css" rel="stylesheet" type="text/css" media="all">
        <link rel="stylesheet" type="text/css" href="css/notify-metro.css">

        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="js/jquery.form.js"></script>
        <script type="text/javascript" src="js/notify.js"></script>
        <script type="text/javascript" src="js/notify-metro.js"></script>
        <script src="js/overlay.js"></script>   

        <script>
         if ('serviceWorker' in navigator) {
            
            navigator.serviceWorker.register('sw.js')
              .then(function(reg){
                console.log("Service worker registered");
             }).catch(function(err) {
                console.log("Service worker error: ", err)
            });
         }
        </script>

        <link rel="manifest" href="/manifest.json">

        
                
        
    </head>

<body>
    
    <div id="application">

        <div id="application-header">

            <h4 style="">

                <p style="float: left; margin:0.8em 0 0.8em 0.5em;" id="backButton" class="hidden goToPage" name="home">< Back</p>

                <i class="fa fa-bars right-side" onclick="openNav()" style="margin:0.8em 1em; display: block;"></i>

                <img src="logo256.png" class="goToPage " name="home" >

                

                <div id="myNav" class="overlay">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                    <div class="overlay-content">
                        <a href="#" class="goToPage" name="about" onclick="closeNav()">About</a>
                        <a href="#" class="goToPage" name="contact" onclick="closeNav()">Contact</a>
                        <a href="#" class="goToPage" name="terms" onclick="closeNav()">Terms</a>
                        
                    </div>
                </div>
            </h4>

        </div>

        <div id="application-body">


            <div class="application-view terms hidden" name="terms">
                
                <h4>Terms and conditions</h4>

                <br>

                @forelse($terms as $term)
                    <h6>{{ $term->contents }}</h6>
                    <br>
                @empty

                    <h6>Use this application carefully.</h6>

                @endforelse

            </div>

            <div class="application-view terror hidden" name="terror">
            	
            </div>

            <div class="application-view contact hidden" name="contact">
                
                <h4>Contact US</h4>

                <h6><b>N/B:</b> This form should be used to contact us. <br>For intelligence submission, click <a href="#" class="btn btn-sm btn-primary goToPage" name="telephone">here</a></h6>

                <br>

                <form method="POST" action="api/contactUs" id="contactUsForm">

                    <input type="hidden" name="_token" id="contactUsToken" value="">

                    <div>
                        <h6>Your name:</h6>
                        <input type="text" name="name" class="form-control" id="contactUsName" value="">
                    </div>

                    <br>

                    <div>
                        <h6>E-mail:</h6>
                        <input type="email" name="email" class="form-control" id="contactUsEmail" value="">
                    </div>

                    <br>

                    <div>
                        <h6>Message:</h6>
                        <textarea class="form-control" name="message" id="contactUsMessage"></textarea>
                    </div>

                    <br>

                    <div>
                        <a href="#" class="btn btn-sm btn-primary" onclick="contactUs()">Send</a>

                        <a href="#" class="btn btn-sm btn-danger right-side" onclick="clearContactUsForm()">Clear</a>
                    </div>


                    
                </form>

                

            </div>

            <div class="application-view about hidden" name="about">
                
                <h4>About US</h4>

                <br>

                <h6>
                    Dabotap is a kenyan civilian security management framework that allows groups to stay abreast of security in their estates. It enables you to send police anonymous tips, converse with fellow Nyumba Kumi members and much more
                </h6>

                <br>

                

            </div>

            <div class="application-view editProfile hidden" name="editProfile">
                
                <h4>Edit Profile</h4>

                <br>

                <div>
                    <h6>Full Name:</h6>
                    <input type="text" name="" class="form-control" id="editProfileName">
                </div>

                <br>

                <div>
                    <h6>Phone:</h6>
                    <input type="text" name="" class="form-control" maxlength="20" id="editProfilePhone">
                </div>

                <br>

                <div>
                    <a href="#" class="btn btn-sm btn-primary" onclick="updateProfile()">Update</a>
                </div>

                <br>

            </div>


            <div class="application-view splash" name="splash">
                
                <img src="images/logo600.png">

            </div>

            

            <div class="application-view home hidden" name="home">
                
                <br>
                <h6 class="middle"> 
                    Dabotap Security Framework 
                </h6>
                <br>

                <img src="images/logo600.png" class="center-50">

                <br><br>

                <h6 style="text-align: center;">
                	Dabotap enables you to stay on top of your own security by leveraging ICT and good citizenship. It enables you to stay abreast with developments around your 'Nyumba Kumi', contact police anonymously, manage your estate's security and much more. 
                    <br>
                    Security starts with you
                </h6>

                <br>


                <h6 class="middle">
                    <span class="btn btn-sm btn-danger goToPage" name="terror">Terror List</span>
                    <span class="btn btn-sm btn-success goToPage" name="users">Watch Tower</span>
                    
                    <span class="btn btn-sm btn-primary goToPage" name="telephone">Big Brother</span>
                </h6>

                <br>

                <h6 class="middle">
                    Tukiungana tutafanya mengi zaidi
                </h6>
                
            </div>

            <div class="application-view login hidden" name="login">

                <form method="post" action="/login" id="loginForm">
                    @csrf
                    <h4>Dabotap Login</h4>
                    <br><br>
                    <h5>
                        Username:
                        <input type="text" name="username" id="loginName" class="form-control">
                    </h5>
                    <br>

                    <h5>
                        Password:
                        <input type="password" name="password" id="loginPassword" class="form-control">
                    </h5>
                    <br>

                    <h5 class="hidden" id="loginText">Logging you in securely ...</h5>

                    <h5>
                        <a href="#" class="btn btn-sm btn-primary" id="tryLogin">Login</a>
                        <a href="#" class="btn btn-sm btn-link goToPage" name="reset">Forgot Password?</a>
                        
                    </h5>

                    <br><br>
                    
                </form>

                <br>
                <br>
                <h5>Don't have an account? 
                <a href="#" class="btn btn-sm btn-success goToPage" name="register">Register Today</a>
                </h5>
                <br>
                
            </div>

            <div class="application-view register hidden" name="register">
                <br>
                <form method="post" action="/register" id="registerForm">
                    <h4>Dabotap Registration</h4>
                    <br><br>
                    @csrf
                    <h5>
                        Full Name:
                        <input type="text"id="registerName" name="name" class="form-control" maxlength="50">
                    </h5>
                    <br>

                    <h5>
                        Username:
                        <input type="text" id="registerUsername" name="username" class="form-control" maxlength="20">
                    </h5>
                    <br>

                    <h5>
                        Phone:
                        <input type="number" id="registerPhone" name="phone" class="form-control" maxlength="20">
                    </h5>
                    <br>

                    <h5>
                        E-mail address:
                        <input type="email" id="registerEmail" name="email" class="form-control">
                    </h5>
                    <br>

                    <h5>
                        Gender:
                        <select id="registerGender" class="form-control" name="gender">
                            <option value="0">select</option>
                            <option value="female">Female</option>
                            <option value="male">Male</option>
                        </select>
                    </h5>
                    <br>

                    <h5>
                        Password:
                        <input type="password" id="registerPassword" name="password" class="form-control">
                    </h5>
                    <br>

                    <h5 class="hidden">
                        Confirm Password:
                        <input type="password" id="registerPasswordConfirmation" name="password_confirmation" class="form-control">
                    </h5>
                    <br>

                    <h5 class="hidden" id="registerText">Creating your account ...</h5>

                    <h5>
                        <a href="#" class="btn btn-sm btn-primary" id="tryRegister">Register</a>
                        <span class="right-side">
                            Have an account? 
                            <a href="#" class="btn btn-sm btn-success goToPage" name="login">Login</a>
                        </span>
                    </h5>
                </form>

                <br>
                <br>
                
            </div>

            <div class="application-view reset hidden" name="reset">
                <br>
                <form>
                    <h4>Reset Password</h4>
                    <br><br>
                    <h5>
                        E-mail address:
                        <input type="text" name="email" id="resetEmail" class="form-control">
                    </h5>
                    <br>

                    <h5 class="hidden" id="resetText">Checking our database ...</h5>

                    <h5>
                        <a href="#" class="btn btn-sm btn-primary" id="tryReset">Reset Password</a>
                        <a href="#" class="btn btn-sm btn-link goToPage" name="login">Login</a>
                    </h5>
                </form>

                <br>
                <br>
                <h5>
                    Don't have an account? 
                    <a href="#" class="btn btn-sm btn-success goToPage" name="register">Register Today</a>
                </h5>
                

                <br>
                
            </div>

            <div class="application-view telephone hidden" name="telephone">
                
                <h5 class="middle">The Big Brother</h5>
                <br>
                <div class="telephone-quick">
                    <a class="telephone-police" href="tel://999">
                        <i class="fa fa-car"></i> <br>Call Police
                    </a>
                    <a class="telephone-hosi" href="tel://999">
                        <i class="fa fa-heart"></i> <br> Ambulence
                    </a>
                    <a class="telephone-help goToPage" href="tel://911">
                        <i class="fa fa-users"></i> <br> Request help
                    </a>
                </div>
                <br style="clear:both">
                <hr>
                <div class="telephone-exposed">
                    <h6>Use this panel to send tips to intelligence</h6>
                    <br style="clear:both">     
                    <button class="btn btn-sm btn-primary">Send Media <i class="fa fa-camera"></i></button>
                    <button class="btn btn-sm btn-success">Send Audio <i class="fa fa-microphone"></i></button>
                    <br style="clear:both">
                    <br style="clear:both">
                    <br style="clear:both">
                    <textarea class="form-control" id="tip-text" placeholder="Type and press enter to send"></textarea>
                    <br style="clear:both">

                    <hr>
                </div>

            </div>
            <div class="application-view users hidden" name="users"></div>

            <div class="application-view profile hidden" name="profile">

                <form method="post" action="api/updateProfileImage" class="hidden" id="profileImageForm" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="" id="profileImageToken">
                    <input type="file" name="image" id="profileImageUploader" onchange="updateProfileImage()">
                </form>

                <div class="profile-header">


                    <img src="images/profiles/avatar.jpg" title="change">

                    <div class="profile-details">
                        <h5>Nicollo Marish </h5>
                        <p>nicollo@lughayetu.net</p>
                    </div>
                    
                </div>
                
                

                <div class="profile-links">

                    <div class="goToPage openAdmin hidden" name="admin">
                        Admin Panel
                        <span class="right-side bigger">></span>
                    </div>
                    <div class="goToPage" name="terms">
                        Terms of Service
                        <span class="right-side bigger">></span>
                    </div>
                    <div class="goToPage" name="contact">
                        Contact
                        <span class="right-side bigger">></span>
                    </div>
                    <div class="goToPage" name="logout">
                        Logout
                        <span class="right-side bigger">></span>
                    </div>
                    
                </div>
                <br><br><br>
            </div>

        </div>

        
        

        <div id="application-footer" class="hidden">
            <div class="application-footerTab goToPage" name="home">
                <i class="fa fa-home active"></i>
            </div>
            <div class="application-footerTab goToPage" name="users">
                <i class="fa fa-users"></i>
            </div>
            <div class="application-footerTab goToPage" name="telephone">
                <i class="fa fa-phone"></i>
            </div>
            <div class="application-footerTab goToPage" name="profile">
                <i class="fa fa-user"></i>
            </div>
        </div>



    </div>

    <script src="js/pwa-2.js"></script>

    
    
    <!--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIoVMj7bma6LA3kpEUHZ1Z3AQ1R_eNs2o&callback=mapLoaded"></script>-->
    

    

</body>
</html>