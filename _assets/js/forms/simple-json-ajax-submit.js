/* --- Basic AJAX Form Processor ---------------------------------------------- ***
 * This script submits a form via Ajax using JDON and then writes the returned
 * results to a division with an ID of #testfield.
 * It returns error messsages for:
 * - Missing required fields.
 * - Errors returned by AJAX.
 * See the code of field and element names used.
 * ---------------------------------------------------------------------------- ***/
// *** Error Messages --------------------------------------------------------- ***
var errMsgs = {
                    // sources                                                  ***
  requiredField     : '<p class="warning"><span class="title">Submission Error:</span> There are required fields that have not been completed.</p>',
  requiredCaptcha   : '<p class="warning"><span class="title">Captcha:</span> Please complete the captcha to submit.</p>',
  // requiredAddr      : '<p class="warning"><span class="title">Submission Error:</span> Please provide an address.</p>',
  // requiredName      : '<p class="warning"><span class="title">Submission Error:</span> Please provide a name.</p>',
};
// *** Submit the form -------------------------------------------------------- ***
$('#fld_submit_btn').click(function(e) {
  event.preventDefault();
  var tResult = '';
  var tOkay = true;
  var tForm = '#' + $('form.primary')[0].id;
                    // Clear error highlights                                   ***
  $('input, textarea').removeClass('missingValue').removeClass('invalidValue');
  $('#testField').html(tResult);
                    // Check required fields                                    ***
  // $('input, textarea').filter('[required]').each(function(i, r) {
  //   if($(r).val()=='') {
  //     $(r).addClass('missingValue');
  //     tOkay = false;
  //   }
  // });
  // if ( !tOkay )  {
  //   tResult = tResult + errMsgs['requiredField'];
  //   $('#testField').html(tResult);
  // }

                    // Check for Google captcha                                 ***
  if ( tOkay )  {
    if ($('#fld_captcha').length) {
      if (!$.trim($('#g-recaptcha-response').val())) {
        tOkay = false;
        tResult = tResult + errMsgs['requiredCaptcha'];
        $('#testField').html(tResult);
      }
    }
  }
                    // Submit the form data                                     ***
  if ( tOkay )  {
      var formData = $(tForm).serializeArray();
    var tSubmits = JSON.stringify( $(tForm).serializeArray(), null, 2 );
    tResult = tResult + '<pre>'+tSubmits+'</pre>';
     $('#fld_submit_btn').prop('value','Processing...');
    // $('#testField').html(tResult);

    var tReply = $.post( './post.php', formData )
    .done(function(data) {
       $('#fld_submit_btn').prop('value','Submit Form');
       $('#fs_submitForm').get(0).scrollIntoView();
       $('#testField').html(data);
      if (!($('.allow-retry').length)) {
//        $('#fld_captcha, #fld_submit_btn, .noprint').hide();
        $('#fs_submitForm legend').text('You may print a copy of this for your records.');
      }
    })
    .fail(function() {
      alert( 'There was an error with this request.' );
    });
  }
});
/*! -- Copyright (c) 2017-2018 Mootly Obviate -- See /LICENSE.md -------------- */
