jQuery('body').on('click','.cww-ssf-toggle,.cww-sff-wrapp i', function(){
		jQuery('.cww-sff-wrapp').toggleClass('active');
	});

jQuery(document).on('click','.newcallcenter_frm .ripple',function(e){

	e.preventDefault();

	var phone_number=jQuery('#txtPhone').val();
	if (validatePhone('txtPhone')) {
		var data = {
            'action': 'newcallcenter_ajax',
            'phone_number' : phone_number
        };
        jQuery.post(newcallcenter_ajax.ajax_url, data, function(response) {

        	//console.log(response);

             jQuery('#txtPhone').val('');

            if(response=='success'){
                 jQuery('.cww-ssf-toggle').trigger('click');
                 // jQuery('#spnPhoneStatus').css('color', 'green');
                 jQuery.toast({
                    //text: newcallcenter_ajax.success_msg, // Text that is to be shown in the toast
                    heading: newcallcenter_ajax.success_msg, // Optional heading to be shown on the toast
                    icon: 'success', // Type of toast icon
                    showHideTransition: 'fade', // fade, slide or plain
                    allowToastClose: true, // Boolean value true or false
                    hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                    stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                    position: 'mid-center', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                    textAlign: 'left',  // Text alignment i.e. left, right or center
                    loader: true,  // Whether to show loader or not. True by default
                    loaderBg: '#9EC600'  // Background color of the toast loader
                });    
                 //jQuery('#spnPhoneStatus').html(newcallcenter_ajax.success_msg);

            }else{

                jQuery('#spnPhoneStatus').html('Something Wrong');
                jQuery('#spnPhoneStatus').css('color', 'red');


            }

        });


	}

});


jQuery(document).ready(function() {
    jQuery('#txtPhone').blur(function(e) {
        jQuery(this).val(jQuery(this).val().replace(/[^a-z0-9]/gi, ''));
        if (validatePhone('txtPhone')) {
            jQuery('#spnPhoneStatus').html('Valid');
            jQuery('#spnPhoneStatus').css('color', 'green');
        }
        else {
            jQuery('#spnPhoneStatus').html('Invalid');
            jQuery('#spnPhoneStatus').css('color', 'red');
        }
    });
});



function validatePhone(txtPhone) {
     var mobNum = jQuery('#txtPhone').val();;
     var validateMobNum= /^\d*(?:\.\d{1,2})?$/;
     if (validateMobNum.test(mobNum ) && (mobNum.length == 9 || mobNum.length == 7 ) ){
        if(mobNum.length==7){
            if(mobNum.indexOf('9')==0){                 
                return false;
            }else{
                 return true;
            }
        }
        return true;
    }else {
        return false;       
    }
   
}