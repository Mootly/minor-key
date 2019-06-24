/* --- Basic AJAX Form Processor ---------------------------------------------- *
 * This script submits a form via Ajax using JSON and then writes the returned
 * results to a division with an ID of #testfield.
 * It returns error messsages for:
 * - Missing required fields.
 * - Errors returned by AJAX.
 * See the code of field and element names used.
 * --- Revision History ------------------------------------------------------- *
 * 2019-06-24 | Added revision log
 * ---------------------------------------------------------------------------- */
// *** Error Messages --------------------------------------------------------- *
var errMsgs = {
                    // missing data - inline errors ('per' field)               *
  per_req_field     : 'This field is required.',
  per_req_address   : 'Please provide an address.',
  per_req_captcha   : 'Please complete the captcha.',
  per_req_date      : 'Please provide a date.',
  per_req_email     : 'Please provide an email address.',
  per_req_name      : 'Please provide a name.',
  per_req_phone     : 'Please provide a phone number.',
                    // missing data - summary errors                             *
  summ_req_field    : 'There are required fields that have not been completed.',
  summ_req_address  : 'A required address is missing.',
  summ_req_captcha  : 'Please complete the captcha.',
  summ_req_date     : 'A required date is mssing.',
  summ_req_email    : 'A required email address is missing.',
  summ_req_name     : 'A required name is missing.',
  summ_req_phone    : 'A required phone number is missing.',
                    // validation errors -inline errors s ('per' field)         *
  per_format_date   : 'Please provide a properly formatted date.',
  per_format_email  : 'Please provide a properly formatted email address.',
  per_format_phone  : 'Please provide a properly formatted 10-digit phone number.',
                    // validation errors - summary errors                       *
  summ_format_date  : 'A date field is not properly formatted for submission.',
  summ_format_email : 'An email address field is not properly formatted for submission.',
  summ_format_phone : 'A phone number field is not properly formatted for submission.',
};
// *** Submit the form -------------------------------------------------------- *
$('#fld_submit_btn').click(function(e) {
  event.preventDefault();
  var tResult = '';
  var tOkay = true;
  var tForm = '#' + $('form.primary')[0].id;
                    // Clear error highlights                                   *
  $('input, textarea').removeClass('missingValue').removeClass('invalidValue');
  $('#testField').html(tResult);
                    // Check required fields                                    *
  // $('input, textarea').filter('[required]').each(function(i, r) {
  //   if($(r).val()=='') {
  //     $(r).addClass('missingValue');
  //     tOkay = false;
  //   }
  // });
  // if ( !tOkay )  {
  //   tResult = tResult + errMsgs['req_field'];
  //   $('#testField').html(tResult);
  // }
                    // Check for Google captcha                                 *
  if ( tOkay )  {
    if ($('#fld_captcha').length) {
      if (!$.trim($('#g-recaptcha-response').val())) {
        tOkay = false;
        tResult = tResult + errMsgs['s_req_captcha'];
        $('#testField').html(tResult);
      }
    }
  }
                    // Submit the form data                                     *
  if ( tOkay )  {
    var formData = $(tForm).serializeArray();
    var tSubmits = JSON.stringify( $(tForm).serializeArray(), null, 2 );
    tResult = tResult + '<pre>'+tSubmits+'</pre>';
    $('#fld_submit_btn').prop('value','Processing...');
    var tPostPath = './post.php';
    if ($('#fld_postpath').val()) { tPostPath = $('#fld_postpath').val(); }
    var tReply = $.post( tPostPath, formData )
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
/*! -- Copyright (c) 2017-2019 Mootly Obviate -- See /LICENSE.md -------------- */
