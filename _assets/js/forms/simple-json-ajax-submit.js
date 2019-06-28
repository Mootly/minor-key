/* --- Basic AJAX Form Processor ---------------------------------------------- *
 * Submit a form via Ajax using JSON.
 * This script returns content and changes the the DOM.
 * Return error messsages for:
 * - Missing required fields.
 * - Validation errors for fields requiring specific formats.
 * - Errors returned by AJAX.
 * Returned content and values:
 * - DOM: div#feedbackOnForm - Feedback and results.
 *   If not in page, will be appended immediately after closing form tag.
 * - DOM: span.errorOnField  - Field-specific errors. See below.
 * - Class: .missingValue - Flag for blank required field.
 * - Class: .invalidValue - Flag for field with invalid data/format.
 * Controls:
 * Accept a global array mp_submitFlags
 * Key                | Default Value | Function
 * suppressErrors     | false         | don't check/report errors, just submit
 - noSummary          | false         | supress error summary at end of form
 - inlinePosition     | 'after'       | inline error before|after|suppress input field
 - customReplyError   |               | HTML block to prepend to feedback on error
 - customReplySuccess |               | HTML black to prepend to feedback on success
 * --- Revision History ------------------------------------------------------- *
 * 2019-06-24 | Added revision log
 * ---------------------------------------------------------------------------- */
// *** Error Messages --------------------------------------------------------- *
var mp_errMsgs = {
                    // missing data - inline errors                             *
  fieldRequired: {
    general:        'This field is required.',
    address:        'Please provide an address.',
    captcha:        'Please complete the captcha.',
    date:           'Please provide a date.',
    email:          'Please provide an email address.',
    name:           'Please provide a name.',
    phone:          'Please provide a phone number.',
  },
                    // validation errors -inline errors s ('per' field)         *
  fieldFormat: {
    date:           'Please provide a properly formatted date.',
    mail:           'Please provide a properly formatted email address.',
    phone:          'Please provide a properly formatted phone number.',
  },
                    // missing data - summary errors                            *
  formRequired: {
    general:        'There are required fields that have not been completed.',
    address:        'Please complete the captcha.',
    date:           'A required date is missing.',
    email:          'A required email address is missing.',
    name:           'A required name is missing.',
    phone:          'A required phone number is missing.',
  },
                    // validation errors - summary errors                       *
  formFormat: {
    date:           'A date field is not properly formatted for submission.',
    email:          'An email address field is not properly formatted for submission.',
    phone:          'A phone number field is not properly formatted for submission.',
  }
}
// *** Submit the form -------------------------------------------------------- *
$('#fld_submit_btn').click(function(e) {
                    // Stop propagation                                         *
  event.preventDefault();
                    // set state                                                *
  var tResult       = '';
  var tOkay         = true;
  var tForm         = '#' + $('form.primary')[0].id;
                    // Clear stale error highlights and information             *
  $('input, textarea').removeClass('missingValue').removeClass('invalidValue');
  $('.errorOnField').remove();
  $('#feedbackOnForm').html(tResult);
                    // Check required fields                                    *
  // $('input, textarea').filter('[required]').each(function(i, r) {
  //   if($(r).val()=='') {
  //     $(r).addClass('missingValue');
  //     tOkay = false;
  //   }
  // });
  // if ( !tOkay )  {
  //   tResult = tResult + mp_eMsgs['req_field'];
  //   $('#testField').html(tResult);
  // }
                    // Check for Google captcha                                 *
  if ( tOkay )  {
    if ($('#fld_captcha').length) {
      if (!$.trim($('#g-recaptcha-response').val())) {
        tOkay = false;
        tResult = tResult + mp_eMsgs['s_req_captcha'];
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
