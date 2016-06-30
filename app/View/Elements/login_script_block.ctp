<script type="text/javascript">
    window.fbAsyncInit = function() {
        FB.init({
            appId: '<?php echo FACEBOOK_APP_ID;?>',
            cookie: true, // enable cookies to allow the server to access 
            xfbml: true,
            version: 'v2.2' // use version 2.2
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    function login() {
        FB.login(function(response) {
            if (response.status === 'connected') {
                //console.log(response.authResponse);
                callfbAPI();
            } else if (response.status === 'not_authorized') {
                alert('Please log into this Mrclass.', 'error');
            } else {
                alert('Please log into facebook.', 'error');
            }
        }, {
            scope: 'public_profile,email,user_friends'
        });
    }

    function callfbAPI() {
        FB.api('/me?fields=name,email,id', function(response) {
            if (response) {
                save_facebook_user(response);
            } else {
                alert('Can not connect to facebook. Please try later.', 'error');
            }
        });
    }

    function save_facebook_user(response) {
        var fb_profile_obj = {};
        fb_profile_obj['social_id'] = response.id;
        fb_profile_obj['UserName'] = response.name;
        fb_profile_obj['UserEmail'] = response.email;
        if (!empty(fb_profile_obj['UserEmail'])) {
            actionHandler(fb_profile_obj, "facebook");
        } else {
            if (trim(CONTROLLER) === "users" && trim(ACTION) === "sign_up") {
                set_sign_up_fields(fb_profile_obj);
            } else if (CONTROLLER == 'users' && ACTION == "login") {
                set_sign_up_from_login(fb_profile_obj, "facebook");
                alert("Success. Please wait while we are redirecting you to sign up page to complete the details.");
                General.hideAlert();
                setTimeout(function() {
                    window.location = window.location = "<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'sign_up')); ?>";
                }, 1000);
            }
        }
    }

    function actionHandler(obj, type) {
        $('.overlay_div').show();
        var url = (type == "google") ? "<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'google_login_new')); ?>" : "<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'facebook_login_new')); ?>";
        $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {
                    data: obj
                },
            }).done(function(response) {
                $('.overlay_div').hide();
                if (response.exist && response.login) {
                    (trim(CONTROLLER) === "users" && trim(ACTION) === "sign_up") ? alert('Please wait while we log you in.. ') : alert('Log In Successful. Please wait..');
                    General.hideAlert();
                    setTimeout(function() {
                            window.location = "<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'dashboard')); ?>";
                        }, 1500);
                } else {
                    if (trim(CONTROLLER) === "users" && trim(ACTION) === "sign_up") {
                        set_sign_up_fields(obj, type);
                    } else if (CONTROLLER == 'users' && ACTION == "login") {
                        set_sign_up_from_login(obj, type);
                        alert("Success. Please wait while we are redirecting you to sign up page to complete the details.");
                        General.hideAlert();
                        setTimeout(function() {
                            window.location = window.location = "<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'sign_up')); ?>";
                        }, 1000);
                    }
                }
            });
    }

    function set_sign_up_fields(obj, type) {
        $.each(obj, function(index, value) {
            (value) ? $('#' + index).val(value): "";
        });
        $('#social_id').attr('name', (type == "google") ? 'data[User][google_id]' : 'data[User][facebook_id]');
        alert("Success. Please provide rest of the details to complete the signup process.");
        General.hideAlert();
    }

    function set_sign_up_from_login(obj, type) {
        var cookie_obj = {};
        cookie_obj['form/name'] = obj.UserName;
        cookie_obj['form/social_id'] = obj.social_id;
        cookie_obj['form/email'] = obj.UserEmail;
        cookie_obj['form/referer_platform'] = type;
        cookie_obj['form/signup_type'] = "social";
        var cookie_string = JSON.stringify(cookie_obj);
        (!empty(getCookie("login_cookie"))) ? removeCookie("login_cookie") : "";
        setCookie("login_cookie", cookie_string);
    }

    function onSignIn(googleUser) {
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function() {
            console.log('User signed out.');
        });
        // Useful data for your client-side scripts:
        var profile = googleUser.getBasicProfile();
        var id_token = googleUser.getAuthResponse().id_token;
        // profile_obj['picture'] = profile.getImageUrl();
        var goole_profile_object = {};
        goole_profile_object['social_id'] = profile.getId();
        goole_profile_object['UserName'] = profile.getName();
        goole_profile_object['UserEmail'] = profile.getEmail();
        actionHandler(goole_profile_object, "google");
    };
</script>