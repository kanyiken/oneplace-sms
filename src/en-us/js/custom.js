// StarHotel Javascripts
jQuery(document).ready(function () {
    "use strict";

	
    //Gmap
    if (jQuery().gMap) {
        jQuery('#map').gMap({
            zoom: 16, //Integer: Level of zoom in to the map
            markers: [{
                address: "Calle Hamburgo, Las Palmas, Spanje", //Address of the company
                html: "<h4>Our hotel</h4><p>This is our hotel</p>", //Quicktip
                popup: false, //Boolean	
                scrollwheel: false, //Boolean
                maptype: 'TERRAIN', //Choose between: 'HYBRID', 'TERRAIN', 'SATELLITE' or 'ROADMAP'.
                icon: {
                    image: "images/ui/gmap-icon.png",
                    iconsize: [42, 53],
                    iconanchor: [12, 46]
                },

                controls: {
                    panControl: false, //Boolean
                    zoomControl: false, //Boolean
                    mapTypeControl: true, //Boolean
                    scaleControl: true, //Boolean
                    streetViewControl: true, //Boolean
                    overviewMapControl: false //Boolean
                }
            }]
        });
    }


    // Owl sliders
    if (jQuery().owlCarousel) {
        jQuery("#owl-gallery").owlCarousel({
            autoPlay: 3000,
            //Set AutoPlay to 3 seconds
            items: 3,
            itemsDesktop: [1199, 3],
            itemsDesktopSmall: [979, 3],
            pagination: false
        });

        jQuery("#owl-reviews").owlCarousel({
            navigation: true,
            // Show next and prev buttons
            slideSpeed: 800,
            paginationSpeed: 400,
            singleItem: true,
            pagination: false,
            navigationText: ['<i class="fa fa-angle-left fa-3x"></i>', '<i class="fa fa-angle-right fa-3x"></i>'],
            // "singleItem:true" is a shortcut for:
            // items : 1, 
            // itemsDesktop : false,
            // itemsDesktopSmall : false,
            // itemsTablet: false,
            // itemsMobile : false
        });

        jQuery("#owl-standard").owlCarousel({
            navigation: true,
            // Show next and prev buttons
            slideSpeed: 300,
            paginationSpeed: 400,
            singleItem: true,
            pagination: false,
            navigationText: ['<i class="fa fa-angle-left fa-3x"></i>', '<i class="fa fa-angle-right fa-3x"></i>'],
            responsive: true,
            responsiveRefreshRate: 200,
            responsiveBaseWidth: window,
            // "singleItem:true" is a shortcut for:
            // items : 1, 
            // itemsDesktop : false,
            // itemsDesktopSmall : false,
            // itemsTablet: false,
            // itemsMobile : false
        });
    }


    // Revolution slider
    if (jQuery().revolution) {
        jQuery('.banner').revolution({
            delay: 9000,
            startwidth: 1170,
            startheight: 449,
            autoHeight:"off",
			fullScreenAlignForce:"off",
            
            onHoverStop: "on",

            thumbWidth: 100,
            thumbHeight: 50,
            thumbAmount: 3,

            hideThumbsOnMobile: "on",
            hideBulletsOnMobile: "on",
            hideArrowsOnMobile: "on",
            hideThumbsUnderResoluition: 0,
			
			hideThumbs:0,
			hideTimerBar:"on",

			keyboardNavigation:"on",
			
            navigationType: "none",
            navigationArrows: "solo",
            navigationStyle: "round",

            navigationHAlign: "center",
            navigationVAlign: "bottom",
            navigationHOffset: 30,
            navigationVOffset: 30,

            soloArrowLeftHalign: "left",
            soloArrowLeftValign: "center",
            soloArrowLeftHOffset: 20,
            soloArrowLeftVOffset: 0,

            soloArrowRightHalign: "right",
            soloArrowRightValign: "center",
            soloArrowRightHOffset: 20,
            soloArrowRightVOffset: 0,

            touchenabled: "on",
			swipe_velocity:"0.7",
			swipe_max_touches:"1",
			swipe_min_touches:"1",
			drag_block_vertical:"false",

            stopAtSlide: -1,
            stopAfterLoops: -1,
            hideCaptionAtLimit: 0,
            hideAllCaptionAtLilmit: 0,
            hideSliderAtLimit: 0,

            dottedOverlay: "none",

			fullWidth:"off",
			forceFullWidth:"off",
            fullScreen: "off",
            fullScreenOffsetContainer: "#topheader-to-offset",

            shadow: 0

        });
    }


    //PrettyPhoto
    if (jQuery().prettyPhoto) {
        jQuery('a[data-rel]').each(function () {
            jQuery(this).attr('rel', jQuery(this).data('rel'));
        });

        jQuery("a[rel^='prettyPhoto']").prettyPhoto({
            social_tools: false,
            animation_speed: 'normal', // fast/slow/normal 
            slideshow: 5000, // false OR interval time in ms
            autoplay_slideshow: false, // true/false
            opacity: 0.80, // Value between 0 and 1 
            show_title: true, // true/false            
			allow_resize: true, // Resize the photos bigger than viewport. true/false
            default_width: 500,
            default_height: 344,
            counter_separator_label: '/', // The separator for the gallery counter 1 "of" 2
            theme: 'pp_default', // light_rounded / dark_rounded / light_square / dark_square / facebook
            horizontal_padding: 20, // The padding on each side of the picture 
            hideflash: false, // Hides all the flash object on a page, set to TRUE if flash appears over prettyPhoto
            wmode: 'opaque', // Set the flash wmode attribute
            autoplay: true, // Automatically start videos: True/False 
            modal: false, // If set to true, only the close button will close the window
            deeplinking: true, // Allow prettyPhoto to update the url to enable deeplinking. 
            overlay_gallery: true, // If set to true, a gallery will overlay the fullscreen image on mouse over 
            keyboard_shortcuts: true, // Set to false if you open forms inside prettyPhoto 
            changepicturecallback: function () {}, // Called everytime an item is shown/changed 
            callback: function () {}, // Called when prettyPhoto is closed
        });
    }


    //Waypoints
    if (jQuery().waypoint) {
        jQuery('.bounce,.flash,.pulse,.shake,.swing,.tada,.wobble,.bounceIn,.bounceInDown,.bounceInLeft,.bounceInRight,.bounceInUp,.bounceOut,.bounceOutDown,.bounceOutLeft,.bounceOutRight,.bounceOutUp,.fadeIn,.fadeInDown,.fadeInDownBig,.fadeInLeft,.fadeInLeftBig,.fadeInRight,.fadeInRightBig,.fadeInUp,.fadeInUpBig,.fadeOut,.fadeOutDown,.fadeOutDownBig,.fadeOutLeft,.fadeOutLeftBig,.fadeOutRight,.fadeOutRightBig,.fadeOutUp,.fadeOutUpBig,.flip,.flipInX,.flipInY,.flipOutX,.flipOutY,.lightSpeedIn,.lightSpeedOut,.rotateIn,.rotateInDownLeft,.rotateInDownRight,.rotateInUpLeft,.rotateInUpRight,.rotateOut,.rotateOutDownLeft,.rotateOutDownRight,.rotateOutUpLeft,.rotateOutUpRight,.slideInDown,.slideInLeft,.slideInRight,.slideOutLeft,.slideOutRight,.slideOutUp,.hinge,.rollIn,.rollOut').waypoint(function () {

            var t = jQuery(this);

            if (jQuery(window).width() < 767) {
                t.delay(jQuery(this).data(1));
                t.addClass("animated");
            } else {
                t.delay(jQuery(this).data("start")).queue(function () {
                    t.addClass("animated");
                });
            }
        }, {
            offset: '75%',
            triggerOnce: true,
        });
    }


    // GO TOP
    //Show or hide "#go-top"
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 300) {

            jQuery('#go-top').fadeIn(200);

        } else {
            jQuery('#go-top').fadeOut(800);
        }
    });
    // Animate "#go-top"
    jQuery('#go-top').click(function (event) {
        event.preventDefault();
        jQuery('html, body').animate({
            scrollTop: 0
        }, '2000', 'swing');
    })

	
    //niceScroll
    if (jQuery().niceScroll) {
         $(".parallax-effect").niceScroll();
		 };
		 

    // Isotope
 window.onload = function () {	
    if (jQuery().isotope) {
        // cache container
        var jQuerycontainer1 = jQuery('.room-list');
        // initialize isotope
        jQuerycontainer1.isotope({
            filter: '*',
            masonry: {
                columnWidth: 1
            }
        });

        // filter items when filter link is clicked
        jQuery('#filters a').click(function () {
            var selector = jQuery(this).attr('data-filter');
            jQuerycontainer1.isotope({
                filter: selector
            });
            return false;
        });
        // set selected menu items
        var jQueryfilters = jQuery('#filters'),
            jQueryfiltersLinks = jQueryfilters.find('a');

        jQueryfiltersLinks.click(function () {
            console.log(this);
            var jQuerythis = jQuery(this).parent(this);
            // don't proceed if already selected
            if (jQuerythis.hasClass('active')) {
                return false;
            }
            var jQueryfilterLink = jQuerythis.parents('#filters');
            jQueryfilterLink.find('.active').removeClass('active');
            jQuerythis.addClass('active');
        });

        var jQuerycontainer2 = jQuery('.gallery');
        // initialize isotope
        jQuerycontainer2.isotope({
            filter: '*',
            masonry: {
                columnWidth: 1,
                gutterWidth: 0
            }
        });

        // filter items when filter link is clicked
        jQuery('#filters a').click(function () {
            var selector = jQuery(this).attr('data-filter');
            jQuerycontainer2.isotope({
                filter: selector
            });
            return false;
        });
        // set selected menu items
        var jQueryfilters = jQuery('#filters'),
            jQueryfiltersLinks = jQueryfilters.find('a');

        jQueryfiltersLinks.click(function () {
            console.log(this);
            var jQuerythis = jQuery(this).parent(this);
            // don't proceed if already selected
            if (jQuerythis.hasClass('active')) {
                return false;
            }
            var jQueryfilterLink = jQuerythis.parents('#filters');
            jQueryfilterLink.find('.active').removeClass('active');
            jQuerythis.addClass('active');
        });
    }
}

    // Sticky Navigation
    if (jQuery().sticky) {
        jQuery(".navbar").sticky({
            topSpacing: 0,
        });;
    }
    var shrinkHeader = 100;
    jQuery(window).scroll(function () {
        var scroll = getCurrentScroll();
        if (scroll >= shrinkHeader) {
            jQuery('.navbar').addClass('shrink');
        } else {
            jQuery('.navbar').removeClass('shrink');
        }
    });

    function getCurrentScroll() {
        return window.pageYOffset || document.documentElement.scrollTop;
    }


    // Dropdown hover
    if (jQuery().dropdownHover) {
        jQuery('.js-activated').dropdownHover().dropdown();
        jQuery(document).on('click', '.yamm .dropdown-menu', function (e) {
            e.stopPropagation()
        })
    }


    // Reservation Form	
    //jQueryUI - Datepicker
    if (jQuery().datepicker) {
        jQuery('#checkin').datepicker({
            showAnim: "drop",
            dateFormat: "dd/mm/yy",
            minDate: "-0D",
        });

        jQuery('#checkout').datepicker({
            showAnim: "drop",
            dateFormat: "dd/mm/yy",
            minDate: "-0D",
            beforeShow: function () {
                var a = jQuery("#checkin").datepicker('getDate');
                if (a) return {
                    minDate: a
                }
            }
        });
        jQuery('#checkin, #checkout').on('focus', function () {
            jQuery(this).blur();
        }); // Remove virtual keyboard on touch devices
    }


    //Popover
    jQuery('[data-toggle="popover"]').popover();


    // Guests
    // Show guestsblock onClick
    var guestsblock = jQuery(".guests");
    var guestsselect = jQuery(".guests-select");
    var save = jQuery(".button-save");
    guestsblock.hide();

    guestsselect.click(function () {
        guestsblock.show();
    });

    save.click(function () {
        guestsblock.fadeOut(120);
    });


    // Count guests script
    var opt1;
    var opt2;
    var total;
    jQuery('.adults select, .children select').change(

        function () {
            opt1 = jQuery('.adults').find('option:selected');
            opt2 = jQuery('.children').find('option:selected');

            total = +opt1.val() + +opt2.val();
            jQuery(".guests-select .total").html(total);
        });



    //Send Data Step One
    $('#loginbutton').click(function(){

        var loginusername    = $('#loginusername').val();
        var loginpassword    = $('#loginpassword').val();

        $('#loginbutton').html('<i class="fa fa-refresh fa-spin"></i>');

        $.post("database/login.php",
            {
                loginusername:loginusername,
                loginpassword:loginpassword
            },
        function(loginresponse){

            $('#loginmessage').html(loginresponse);
            $('#loginbutton').html('Login');
            
            if(loginresponse.feedback == 'runsteptwo')
            {
                window.location.href = "two-factor-login.php";
            }else if(loginresponse.feedback == 'successlogin')
            {
                window.location.href = "index.php";
            }
        }); 
    });
    //Send Data Step Two :-)
    $('#forgotpasswordbutton').click(function(){

        var loginusername    = $('#loginusername').val();

        $('#forgotpasswordbutton').html('<i class="fa fa-refresh fa-spin"></i>');

        $.post("database/reset-password.php",
            {
                loginusername:loginusername
            },
        function(loginresponse){

            $('#loginmessage').html(loginresponse);
            $('#forgotpasswordbutton').html('Recover Password');
            
            if(loginresponse.feedback == 'hassteptwo')
            {
                window.location.href = "reset-password-step-two.php";
            }
            else if(loginresponse.feedback == 'successreset')
            {
                window.location.href = "reset-password-confirmation.php";
            }
			else
			{
				$('#loginmessage').html(loginresponse.feedback);
			}
        }); 
    });

    //Send Data Step One
    $('#twofactorloginbutton').click(function()
    {

        var twofactorpassword    = $('#twofactorpassword').val();

        $('#twofactorloginbutton').html('<i class="fa fa-refresh fa-spin"></i>');

        $.post("database/two-factor-login.php",
            {
                twofactorpassword:twofactorpassword
            },
        function(factorresponse){

            $('#twofactorloginmessage').html(factorresponse);
            $('#twofactorloginbutton').html('Continue&raquo');
            
            if(factorresponse.feedback == 'passtoprofile')
            {           
                window.location.href = "index.php";
            }else if(loginresponse.feedback == 'requestlogin')
            {
                window.location.href = "sms-login.php";
            }
        }); 
    });

    //Send Data Step One
    $('#sendopenmessage').click(function()
    {

        var openphonenumber    = $('#openphonenumber').val();
        var openmessage        = $('#openmessage').val().replace(/\n/g, " ");

        $('#sendopenmessage').html('<i class="fa fa-refresh fa-spin"></i>');

        $.post("database/send-open-message.php",
            {
                openphonenumber:openphonenumber,
                openmessage:openmessage
            },
        function(openmessageresponse){

            $('#openmessagetext').html(openmessageresponse);
            $('#sendopenmessage').html('Send Message');

        }); 
    });

    //Send Data Step One
    $('#grmessage a').click(function()
    {

        var gmidentity         = $(this).attr('value');
        var gmmessage          = $('#groupmsg'+gmidentity).val().replace(/\n/g, " ");

        $('#sendgroupmsg'+gmidentity).html('<i class="fa fa-refresh fa-spin"></i>');

        $.post("database/send-group-message.php",
            {
                gmidentity:gmidentity,
                gmmessage:gmmessage
            },
        function(gmresponse)
        {
            $('#grouptextresp'+gmidentity).html(gmresponse);
            $('#sendgroupmsg'+gmidentity).html('Send Message');
        }); 
    });

    //Send Data Step One
    $('#vgroup').click(function()
    {

        var vgroupno          = $('#vgroupno').val();
        var vmessage          = $('#vmessage').val().replace(/\n/g, " ");

        $('#vgroup').html('<i class="fa fa-refresh fa-spin"></i>');

        $.post("database/send-group-message2.php",
            {
                vgroupno:vgroupno,
                vmessage:vmessage
            },
        function(vresponse)
        {
            $('#vresp').html(vresponse);
            $('#vgroup').html('Send Group Message');
        }); 
    });

    //Send Data Step One
    $('#message a').click(function()
    {
        var msgidentity        = $(this).attr('value');
        var inlineno           = $('#inlineno'+msgidentity).val();
        var inlinemsg          = $('#inlinemsg'+msgidentity).val().replace(/\n/g, " ");

        $('#sendinlinemsg'+msgidentity).html('<i class="fa fa-refresh fa-spin"></i>');

        $.post("database/send-inline-message.php",
            {
                inlineno:inlineno,
                inlinemsg:inlinemsg
            },
        function(inlinemessageresponse){

            $('#inlinemessagetext'+msgidentity).html(inlinemessageresponse);
            $('#sendinlinemsg'+msgidentity).html('Send Message');

        }); 
    });

    //Send airtime
    $('.sendgroupairtimebtn').click(function()
    {
        var msgidentity        = $(this).attr('value');
        var airtimeamount      = parseInt($('#airtimeamount'+msgidentity).val()) ? parseInt($('#airtimeamount'+msgidentity).val()) : 0;
        var group_id		   = $('#airtimegroupid'+msgidentity).val();
        
        //sendairtimebtn
        $('#sendairtimebtn'+msgidentity).html('<i class="fa fa-refresh fa-spin"></i>');
        
        $.post("database/group-send-airtime.php",
            {
                airtimeamount:airtimeamount,
                group_id:group_id
            },
        function(inlinemessageresponse){

            $('#airtimemessagetext'+msgidentity).html(inlinemessageresponse);
            $('#sendairtimebtn'+msgidentity).html('Send Airtime');

        });
    });
    
	//Send airtime
    $('.sendairtime a').click(function()
    {
        var msgidentity        = $(this).attr('value');
        var airtimeamount      = parseInt($('#airtimeamount'+msgidentity).val()) ? parseInt($('#airtimeamount'+msgidentity).val()) : 0;
        var phone_number       = $('#airtimenumber'+msgidentity).val();
        
        //sendairtimebtn
        $('#sendairtimebtn'+msgidentity).html('<i class="fa fa-refresh fa-spin"></i>');
        
        $.post("database/contact-send-airtime.php",
            {
                airtimeamount:airtimeamount,
                phone_number:phone_number
            },
        function(inlinemessageresponse){

            $('#airtimemessagetext'+msgidentity).html(inlinemessageresponse);
            $('#sendairtimebtn'+msgidentity).html('Send Airtime');

        });
    });
	
    //Send Contacts
    $('#cclick').click(function()
    {

        var cname        = $('#cname').val();
        var corg         = $('#corg').val();
        var cphone       = $('#cphone').val();

        $('#cclick').html('<i class="fa fa-refresh fa-spin"></i>');

        $.post("database/add-contact.php",
            {
                cname:cname,
                corg:corg,
                cphone:cphone
            },
        function(addcresponse)
        {
            $('#cresp').html(addcresponse);
            $('#cclick').html('Add Contact');

            if (addcresponse =='<p style="color:green"><i class="fa fa-check-square"></i> Contact added</p>') 
                {
                    document.location.reload(true);
                }
        }); 
    });

	//Send Contacts
    $('#upload-contacts').click(function()
    {
        var url = $('#bulk-import-form').attr('action');
        var xhr = new XMLHttpRequest();
        var fd = new FormData();
        
        xhr.open('POST', url, true);
        
        xhr.onreadystatechange = function()
        {
            if (xhr.readyState == 4 && xhr.status == 200) {
                $('#uresp').html(xhr.responseText);
            }
        };
        
        fd.append('upload_file', document.getElementById('userfile').files[0]);
        xhr.send(fd);
    });
	
    //Edit Contacts
    $('#footedit a').click(function()
    {
        var identity        = $(this).attr('value');
        var newcname         = $('#cname'+identity).val();
        var newcorg         = $('#corg'+identity).val();
        var newcphone       = $('#cphone'+identity).val();

        $('#cclick'+identity).html('<i class="fa fa-refresh fa-spin"></i>');

        $.post("database/edit-contact.php",
            {
                identity:identity,
                newcname:newcname,
                newcorg:newcorg,
                newcphone:newcphone
            },
        function(editcresponse)
        {
            $('#cresp'+identity).html(editcresponse);
            $('#cclick'+identity).html('Update');
        }); 
    });

    // New Group
    $('#groupclick').click(function()
    {

        var newgroupname    = $('#newgroupname').val();

        $('#groupclick').html('<i class="fa fa-refresh fa-spin"></i>');

        $.post("database/add-group.php",
            {
                newgroupname:newgroupname
            },
        function(groupresponse){

            $('#newgroupresp').html(groupresponse);
            $('#groupclick').html('Add Group');

        }); 
    });

    // New Group
    $('#footgedit a').click(function()
    {
        var gidentity        = $(this).attr('value');
        var editgroupname    = $('#gname'+gidentity).val();

        $('#gclick'+gidentity).html('<i class="fa fa-refresh fa-spin"></i>');

        $.post("database/edit-group.php",
            {
                gidentity:gidentity,
                editgroupname:editgroupname
            },
        function(gresponse)
        {
            $('#gresp'+gidentity).html(gresponse);
            $('#gclick'+gidentity).html('Update');
        }); 
    });

    // Add to group
    $('#addtgroup').click(function()
    {
        var thisgroup         = $('#thisgroup').val();

        var chkArray = [];

        $(".checkBoxClass:checked").each(function() {
            chkArray.push($(this).attr('value'));
        });

        $('#addtgroup').html('<i class="fa fa-refresh fa-spin"></i>');

        $.post("database/add-to-group.php",
            {
                thisgroup:thisgroup,
                chkArray:chkArray
            },
        function(addtoresp)
            {
                $('#addtoresp').html(addtoresp);
                $('#addtgroup').html('Add Members');
            }); 
    });

    // New Group
    $('#adduser').click(function()
    {

        var uemail          = $('#uemail').val();
        var uusername       = $('#uusername').val();
        var uphone          = $('#uphone').val();
        var upassword       = $('#upassword').val();
        var uopenmessage    = $('#uopenmessage').val();
        var ugroupmessage   = $('#ugroupmessage').val();
        var ubroadcast      = $('#ubroadcast').val();
        var uviewlogs       = $('#uviewlogs').val();
        var uaddcontact     = $('#uaddcontact').val();
        var uaddgroup       = $('#uaddgroup').val();
        var uremovecg       = $('#uremovecg').val();
        var uviewcredits    = $('#uviewcredits').val();

        $('#adduser').html('<i class="fa fa-refresh fa-spin"></i>');

        $.post("database/add-user.php",
            {
                uemail:uemail,
                uusername:uusername,
                uphone:uphone,
                upassword:upassword,
                uopenmessage:uopenmessage,
                ugroupmessage:ugroupmessage,
                ubroadcast:ubroadcast,
                uviewlogs:uviewlogs,
                uaddcontact:uaddcontact,
                uaddgroup:uaddgroup,
                uremovecg:uremovecg,
                uviewcredits:uviewcredits
            },
        function(userresponse){

            $('#adduserresp').html(userresponse);
            $('#adduser').html('Add User');

        }); 
    });

    // System Settings
    $('#ss').click(function()
    {

        var twofactor       = $('#twofactor').val();
        var resettype       = $('#resettype').val();

        $('#ss').html('<i class="fa fa-refresh fa-spin"></i>');

        $.post("database/system-settings.php",
            {
                twofactor:twofactor,
                resettype:resettype
            },
        function(ssresponse){

            $('#ssresp').html(ssresponse);
            $('#ss').html('Save Changes');

        }); 
    });



     // SMS Settings
    $('#smsclick').click(function()
    {

        var as_user       = $('#as_user').val();
        var as_key        = $('#as_key').val();
        var as_senderid   = $('#as_senderid').val();
        var asalertvalue  = $('#asalertvalue').val();

        $('#smsclick').html('<i class="fa fa-refresh fa-spin"></i>');

        $.post("database/sms-settings.php",
            {
                as_user:as_user,
                as_key:as_key,
                as_senderid:as_senderid,
                asalertvalue:asalertvalue
            },
        function(smsresponse){

            $('#smsresponse').html(smsresponse);
            $('#smsclick').html('Save Changes');

        }); 
    });
	
	
     //Email Settings
    $('#emailsettingsclick').click(function()
    {

        var email_protocol		= $('#email-protocol').val();
        var email_from			= $('#email-from').val();
        var email_from_name		= $('#email-from-name').val();
        var email_smtp_host		= $('#email-smtp-host').val();
        var email_smtp_secure	= $('#email-smtp-secure').val();
        var email_smtp_port		= $('#email-smtp-port').val();
        var email_smtp_user		= $('#email-smtp-user').val();
        var email_smtp_pass		= $('#email-smtp-pass').val();
		var id					= $('#settings-id').val();

        $('#emailsettingsclick').html('<i class="fa fa-refresh fa-spin"></i>');

        $.post("database/mail-settings.php",
            {
                id:id,
				email_protocol:email_protocol,
                email_from:email_from,
                email_from_name:email_from_name,
                email_smtp_host:email_smtp_host,
                email_smtp_secure:email_smtp_secure,
                email_smtp_port:email_smtp_port,
                email_smtp_user:email_smtp_user,
                email_smtp_pass:email_smtp_pass
            },
        function(smsresponse){

            $('#smsresponse').html(smsresponse);
            $('#emailsettingsclick').html('Save Changes');

        }); 
    });

     // Update Phone Number
    $('#updatephone').click(function()
    {

        var upphone       = $('#upphone').val();

        $('#updatephone').html('<i class="fa fa-refresh fa-spin"></i>');

        $.post("database/change-phone.php",
            {
                upphone:upphone
            },
        function(phoneresponse){

            $('#upresp').html(phoneresponse);
            $('#updatephone').html('Save Changes');

        }); 
    });

    // Change Password
    $('#changepassword').click(function()
    {

        var oldpassword          = $('#oldpassword').val();
        var newpassword          = $('#newpassword').val();
        var confirmnewpassword   = $('#confirmnewpassword').val();


        $('#changepassword').html('<i class="fa fa-refresh fa-spin"></i>');

        $.post("database/admin-settings.php",
            {
                oldpassword:oldpassword,
                newpassword:newpassword,
                confirmnewpassword:confirmnewpassword,
            },
        function(passchange){

            $('#passresp').html(passchange);
            $('#changepassword').html('Change Password');

        }); 
    });



    // Edit User
    $('#userfoot a').click(function()
    {

        var attach          = $(this).attr('value');

        var euphone          = $('#euphone'+attach).val();
        var euopenmessage    = $('#euopenmessage'+attach).val();
        var eugroupmessage   = $('#eugroupmessage'+attach).val();
        var eubroadcast      = $('#eubroadcast'+attach).val();
        var euviewlogs       = $('#euviewlogs'+attach).val();
        var euaddcontact     = $('#euaddcontact'+attach).val();
        var euaddgroup       = $('#euaddgroup'+attach).val();
        var euremovecg       = $('#euremovecg'+attach).val();
        var euviewcredits    = $('#euviewcredits'+attach).val();

        $('#adduser'+attach).html('<i class="fa fa-refresh fa-spin"></i>');

        $.post("database/edit-user.php",
            {
                attach:attach,
                euphone:euphone,
                euopenmessage:euopenmessage,
                eugroupmessage:eugroupmessage,
                eubroadcast:eubroadcast,
                euviewlogs:euviewlogs,
                euaddcontact:euaddcontact,
                euaddgroup:euaddgroup,
                euremovecg:euremovecg,
                euviewcredits:euviewcredits
            },
        function(userresponse){

            $('#adduserresp'+attach).html(userresponse);
            $('#adduser'+attach).html('Add User');

        }); 
    });

});
