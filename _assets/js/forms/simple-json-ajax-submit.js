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
 * ---------------------------------------------------------------------------- *
 * Controls:
 * Accept a global array mp_submitFlags
 * Key              | Default Value     | Function
 * noErrorCheck     | false             | don't check/report errors, just submit
 * noSummary        | false             | supress error summary at end of form
 * inlinePos        | 'after'           | inline error before | after | suppress
 * replyOnError     |                   | HTML block to prepend to feedback on error
 * replyOnSuccess   |                   | HTML black to prepend to feedback on success
 * ---
 * Accept a class to define field type or a data attribute of data-ftype
 * class=ftype_<type>
 * <type> = address | captcha | name | user | any valid HTML <input /> type
 * Cascade: data-ftype, class, type
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
    file:           'Please include an attachment.',
    name:           'Please provide a name.',
    password:       'Please provide a password.',
    phone:          'Please provide a phone number.',
    url:            'Please provide a URL/URI.',
    user:           'Please provide a user ID.',
  },
                    // validation errors -inline errors s ('per' field)         *
  fieldFormat: {
    date:           'Please provide a properly formatted date.',
    mail:           'Please provide a properly formatted email address.',
    phone:          'Please provide a properly formatted phone number.',
    url:            'Please provide a properly formatted URL/URI.',
  },
                    // missing data - summary errors                            *
  formRequired: {
    general:        'There are required fields that have not been completed.',
    address:        'A required address is missing.',
    captcha:        'Please complete the captcha.',
    date:           'A required date is missing.',
    email:          'A required email address is missing.',
    file:           'A required attachment is missing.',
    name:           'A required name is missing.',
    password:       'Please provide a password.',
    phone:          'A required phone number is missing.',
    url:            'A required URL/URI is missing.',
    user:           'Please provide a user ID.',
  },
                    // validation errors - summary errors                       *
  formFormat: {
    date:           'A date field is not properly formatted for submission.',
    email:          'An email address field is not properly formatted for submission.',
    phone:          'A phone number field is not properly formatted for submission.',
    url:            'A URL/URI field is not properly formatted for submission.',
  }
}
// *** ------------------------------------------------------------------------ *
// *** Submit the form -------------------------------------------------------- *
$('#fld_submit_btn').click(function(e) {
                    // *** init our script ------------------------------------ *
                    // Stop propagation                                         *
  event.preventDefault();
                    // set initial state -  no results, no errors               *
  var summaryReport = $('<div>').addClass('submit_summary');
  var inlineMsg     = '';
  var reportMsg     = '';
  var isOkay        = true;
  var fldID         = '';
  var fldType       = 'text';
                    // assign our form to a variable                            *
  var formData      = '#' + $('form.primary')[0].id;
  var targetField   = '';
                    // assign our flags to variables                            *
  var checkErrors   = mp_submitFlags['noErrorCheck']
                    ? false
                    : true;
  var showSummary   = mp_submitFlags['noSummary']
                    ? false
                    : true;
  var customErrMsg  = mp_submitFlags['replyOnError']
                    ? mp_submitFlags['replyOnError']
                    : '';
  var customPostMsg = mp_submitFlags['replyOnSuccess']
                    ? mp_submitFlags['replyOnSuccess']
                    : '';
  var showSummary   = mp_submitFlags['noSummary']
                    ? false
                    : true;
  var showInline    = (mp_submitFlags['inlinePos'] == 'suppress')
                    ? false
                    : true;
  var inlinePos     = (mp_submitFlags['inlinePos'] == 'before')
                    ? 'before'
                    : 'after';
                    // clear stale error highlights and information             *
  $('input, textarea').removeClass('missingValue').removeClass('invalidValue');
  $('.errorOnField').remove();
  $('#feedbackOnForm').html(tResult);
// *** ------------------------------------------------------------------------ *
// *** Begin Error Checking --------------------------------------------------- *
  if ( checkErrors ) {
                    // *** Check required fields ------------------------------ *
                    // if empty, generate error messages
    $('input, textarea').filter('.required, [required]').each(function() {
      if($(this).val() == '') {
        $(this).addClass('missingValue');
        isOkay      = false;
                    // determine field id/type is generating the error
        fldID       = $(this).attr('id');
        fldType     = $(this).attr('data-ftype')
                    ? $(this).attr('data-ftype')
                    : $(this).attr('class').match(/ftype_\w+/)[0]
                    ? $(this).attr('class').match(/ftype_\w+/)[0]
                    : $(this).attr('type');
                    // assign our error messages
        switch (fldType) {
        case 'address':                       // class
          inlineMsg = mp_errMsgs['fieldRequired']['address'];
          inlineMsg = mp_errMsgs['formRequired']['address'];
          break;
        case 'captcha':                       // class
          inlineMsg = mp_errMsgs['fieldRequired']['captcha'];
          inlineMsg = mp_errMsgs['formRequired']['captcha'];
          break;
        case 'date':                          // type
        case 'datetime-local':                // type
          inlineMsg = mp_errMsgs['fieldRequired']['date'];
          inlineMsg = mp_errMsgs['formRequired']['date'];
          break;
        case 'email':                         // type
          inlineMsg = mp_errMsgs['fieldRequired']['email'];
          inlineMsg = mp_errMsgs['formRequired']['email'];
          break;
        case 'name':                          // class
          inlineMsg = mp_errMsgs['fieldRequired']['name'];
          inlineMsg = mp_errMsgs['formRequired']['name'];
          break;
        case 'password':                      // type
          inlineMsg = mp_errMsgs['fieldRequired']['password'];
          inlineMsg = mp_errMsgs['formRequired']['password'];
          break;
        case 'phone':                         // class
        case 'tel':                           // type
          inlineMsg = mp_errMsgs['fieldRequired']['phone'];
          inlineMsg = mp_errMsgs['formRequired']['phone'];
          break;
        case 'file':                          // type
        case 'image':                         // type
          inlineMsg = mp_errMsgs['fieldRequired']['file'];
          inlineMsg = mp_errMsgs['formRequired']['file'];
          break;
        case 'url':                           // type
          inlineMsg = mp_errMsgs['fieldRequired']['url'];
          inlineMsg = mp_errMsgs['formRequired']['url'];
          break;
        default:
          inlineMsg = mp_errMsgs['fieldRequired']['general'];
          inlineMsg = mp_errMsgs['formRequired']['general'];
          break;
        }
      }
    });
                    // *** Check fields needing validation -------------------- *
                    // only checks fields that have a pattern attribute         *
                    // uses the pattern for validation                          *

                    // *** Check for Google captcha --------------------------- *
                    // no need to bash them over head about captcha             *
                    // if the form has other problems                           *
    if ( isOkay ) {
      if ($('#fld_captcha').length) {
        if (!$.trim($('#g-recaptcha-response').val())) {
          isOkay = false;
        }
      }
    }
    if ( !isOkay )  {
      if ( showInline ) {

      }
      if ( showSummary ) {

      }
    }

  }
// *** End Error Checking ----------------------------------------------------- *
// *** ------------------------------------------------------------------------ *
// *** Submit the form data --------------------------------------------------- *
  if ( isOkay )  {
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
