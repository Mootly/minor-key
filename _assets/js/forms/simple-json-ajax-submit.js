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
 * Accept a global array mpv_submitFlags
 * Key              | Default Value     | Function
 * noErrorCheck     | false             | don't check/report errors, just submit
 * noSummary        | false             | supress error summary at end of form
 * inlinePos        | 'after'           | inline error before | after | suppress
 * replyOnError     |                   | HTML block to prepend to feedback on error
 * replyOnSuccess   |                   | HTML black to prepend to feedback on success
 * ---
 * Accept a class to define field type or a data attribute of data-ftype
 * <type> = address | captcha | name | user | any valid HTML <input /> type
 * data-ftype takes precendence over type
 * --- Revision History ------------------------------------------------------- *
 * 2019-07-09 | Added server-side validations for non-HTML5 browsers
 * 2019-06-24 | Added revision log
 * ---------------------------------------------------------------------------- */
// *** Error Messages --------------------------------------------------------- *
var mpv_errMsgs = {
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
    general:        'Please see the form directions for formatting information for this field.',
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
    general:        'There is an improperly formatted field. Please see the form directions.',
  }
}
// *** ------------------------------------------------------------------------ *
// *** BEGIN Main function ---------------------------------------------------- *
$('#fld_submit_btn').click(function(e) {
                    // *** init our script ------------------------------------ *
                    // Stop propagation                                         *
  event.preventDefault();
                    // set initial state -  no results, no errors               *
  var isOkay        = true;
  var fprop_ID      = '';
  var fprop_type    = 'text';
                    // create our error report elements                         *
  var $_inlineMsg   = $('<span />', {'class': 'errorOnField'});
  var $_reportMsg   = $('<li />');
  var $_summaryRpt  = $('<div />', {id: 'submit_summary', 'class': 'warning'});
  $('<h3 />', {id: 'h3_submit_summary'}).text('This form appears to have errors and is not ready to submit:').appendTo($_summaryRpt);
  $('<ul />', {'id': 'ul_submit_summary'}).appendTo($_summaryRpt);
                    // assign our form to a variable                            *
  var form_ID       = '#' + $('form.primary')[0].id;
  var targetField   = '';
                    // assign our flags to variables                            *
  if (typeof mpv_submitFlags === 'undefined') { mpv_submitFlags = ['']; }
  var checkErrors   = mpv_submitFlags['noErrorCheck']
                    ? false
                    : true;
  var customErrMsg  = mpv_submitFlags['replyOnError']
                    ? mpv_submitFlags['replyOnError']
                    : '';
                    $_summaryRpt.append(customErrMsg);
  var customPostMsg = mpv_submitFlags['replyOnSuccess']
                    ? mpv_submitFlags['replyOnSuccess']
                    : '';
  var showSummary   = mpv_submitFlags['noSummary']
                    ? false
                    : true;
  var showInline    = (mpv_submitFlags['inlinePos'] == 'suppress')
                    ? false
                    : true;
  var showBefore    = (mpv_submitFlags['inlinePos'] == 'before')
                    ? true
                    : false;
                    // clear stale error highlights and information             *
  $('input, textarea').removeClass('missingValue').removeClass('invalidValue');
  $('.errorOnField').remove();
  $('#feedbackOnForm').empty();
// *** ------------------------------------------------------------------------ *
// *** BEGIN Error Checking --------------------------------------------------- *
  if ( checkErrors ) {
// *** BEGIN Check required fields -------------------------------------------- *
                    // if empty, generate error messages
    $('input, textarea').filter('.required, [required]').each(function() {
      if($(this).val() == '') {
        $(this).addClass('missingValue');
        isOkay      = false;
                    // determine field id/type is generating the error
        fprop_ID    = $(this).attr('id');
        fprop_type  = $(this).attr('data-ftype')
                    ? $(this).attr('data-ftype')
                    : $(this).attr('type');
                    // assign our error messages
        switch (fprop_type) {
        case 'address':                       // class
          $_inlineMsg.html(mpv_errMsgs['fieldRequired']['address']);
          $_reportMsg.html(mpv_errMsgs['formRequired']['address']);
          break;
        case 'captcha':                       // class
          $_inlineMsg.html(mpv_errMsgs['fieldRequired']['captcha']);
          $_reportMsg.html(mpv_errMsgs['formRequired']['captcha']);
          break;
        case 'date':                          // type
        case 'datetime-local':                // type
          $_inlineMsg.html(mpv_errMsgs['fieldRequired']['date']);
          $_reportMsg.html(mpv_errMsgs['formRequired']['date']);
          break;
        case 'email':                         // type
          $_inlineMsg.html(mpv_errMsgs['fieldRequired']['email']);
          $_reportMsg.html(mpv_errMsgs['formRequired']['email']);
          break;
        case 'name':                          // class
          $_inlineMsg.html(mpv_errMsgs['fieldRequired']['name']);
          $_reportMsg.html(mpv_errMsgs['formRequired']['name']);
          break;
        case 'password':                      // type
          $_inlineMsg.html(mpv_errMsgs['fieldRequired']['password']);
          $_reportMsg.html(mpv_errMsgs['formRequired']['password']);
          break;
        case 'phone':                         // class
        case 'tel':                           // type
          $_inlineMsg.html(mpv_errMsgs['fieldRequired']['phone']);
          $_reportMsg.html(mpv_errMsgs['formRequired']['phone']);
          break;
        case 'file':                          // type
        case 'image':                         // type
          $_inlineMsg.html(mpv_errMsgs['fieldRequired']['file']);
          $_reportMsg.html(mpv_errMsgs['formRequired']['file']);
          break;
        case 'url':                           // type
          $_inlineMsg.html(mpv_errMsgs['fieldRequired']['url']);
          $_reportMsg.html(mpv_errMsgs['formRequired']['url']);
          break;
        default:
          $_inlineMsg.html(mpv_errMsgs['fieldRequired']['general']);
          $_reportMsg.html(mpv_errMsgs['formRequired']['general']);
          break;
        }
                    // generate inline errors --------------------------------- *
                    // use clone to ensure pass by value, not by reference
        if (showInline) {
          if (showBefore) {
            $(this).before($_inlineMsg.clone());
          } else {
            $(this).after($_inlineMsg.clone());
          }
        }
                    // build summary report ----------------------------------- *
                    // use clone to ensure pass by value, not by reference
        if (showSummary) {
          $_summaryRpt.find('#ul_submit_summary').append($_reportMsg.clone());
        }
      }
    });
// *** END Check required fields ---------------------------------------------- *
// *** BEGIN Check fields needing validation ----------==============---------- *
                    // only checks fields that have a pattern attribute         *
                    // uses the pattern for validation                          *
    $('input').filter('[pattern]').each(function() {
      var test_string  = $(this).val();
      var test_pattern = new RegExp($(this).attr('pattern'));
      if((test_string.search(test_pattern) == -1) && test_string != '') {
        $(this).addClass('invalidValue');
        isOkay      = false;
                    // determine field id/type is generating the error
        fprop_ID    = $(this).attr('id');
        fprop_type  = $(this).attr('data-ftype')
                    ? $(this).attr('data-ftype')
                    : $(this).attr('type');
                    // assign our error messages
        switch (fprop_type) {
        case 'date':                          // type
        case 'datetime-local':                // type
          $_inlineMsg.html(mpv_errMsgs['fieldFormat']['date']);
          $_reportMsg.html(mpv_errMsgs['formFormat']['date']);
          break;
        case 'email':                         // type
          $_inlineMsg.html(mpv_errMsgs['fieldFormat']['email']);
          $_reportMsg.html(mpv_errMsgs['formFormat']['email']);
          break;
        case 'phone':                         // class
        case 'tel':                           // type
          $_inlineMsg.html(mpv_errMsgs['fieldFormat']['phone']);
          $_reportMsg.html(mpv_errMsgs['formFormat']['phone']);
          break;
        case 'url':                           // type
          $_inlineMsg.html(mpv_errMsgs['fieldFormat']['url']);
          $_reportMsg.html(mpv_errMsgs['formFormat']['url']);
          break;
        default:
          $_inlineMsg.html(mpv_errMsgs['fieldFormat']['general']);
          $_reportMsg.html(mpv_errMsgs['formFormat']['general']);
          break;
        }
                    // generate inline errors --------------------------------- *
                    // use clone to ensure pass by value, not by reference
        if (showInline) {
          if (showBefore) {
            $(this).before($_inlineMsg.clone());
          } else {
            $(this).after($_inlineMsg.clone());
          }
        }
                    // build summary report ----------------------------------- *
                    // use clone to ensure pass by value, not by reference
        if (showSummary) {
          $_summaryRpt.find('#ul_submit_summary').append($_reportMsg.clone());
        }
      }
    });
// *** END Check fields needing validation ------------------------------------ *
// *** BEGIN Check for Google captcha ----------------------------------------- *
                    // no need to bash them over head about captcha             *
                    // if the form has other problems                           *
    if ( isOkay ) {
      if ($('#fld_captcha').length) {
        if (!$.trim($('#g-recaptcha-response').val())) {
          isOkay = false;
          $_inlineMsg.html(mpv_errMsgs['fieldRequired']['captcha']);
          $_reportMsg.html(mpv_errMsgs['formRequired']['captcha']);
                    // generate inline errors --------------------------------- *
                    // use clone to ensure pass by value, not by reference
          if (showInline) {
            if (showBefore) {
              $('#g-recaptcha-response').before($_inlineMsg.clone());
            } else {
              $('#g-recaptcha-response').after($_inlineMsg.clone());
            }
          }
                    // build summary report ----------------------------------- *
                    // use clone to ensure pass by value, not by reference
          if (showSummary) {
            $_summaryRpt.find('#ul_submit_summary').append($_reportMsg.clone());
          }
        }
      }
    }
// *** END Check for Google captcha ------------------------------------------- *
// *** BEGIN Summary report generation ---------------------------------------- *
    if ( !(isOkay) && (showSummary) ) {
      var t_uniques = {};
      $_summaryRpt.find('#ul_submit_summary li').each(function() {
        var t_content = $(this).text();
        if (t_uniques[t_content]) {
          $(this).remove();
        } else {
          t_uniques[t_content] = true;
        }
      });
      $('#feedbackOnForm').append($_summaryRpt);

    }
// *** END Summary report generation ------------------------------------------ *
  }
// *** END Error Checking ----------------------------------------------------- *

// }
// *** End Error Checking ----------------------------------------------------- *
// *** ------------------------------------------------------------------------ *
// *** BEGIN Submit the form data --------------------------------------------- *

  if ( isOkay )  {
    var json_fData  = $(form_ID).serializeArray();
// var tSubmits      = JSON.stringify( $(form_ID).serializeArray(), null, 2 );
// tResult           = tResult + '<pre>'+tSubmits+'</pre>';
    $('#fld_submit_btn').prop('value','Processing...');
    var post_path   = $('#fld_postpath').val()
                    ? $('#fld_postpath').val()
                    : $(form_ID).attr('action');

    var post_path = './post.php';
    if ($('#fld_postpath').val()) { post_path = $('#fld_postpath').val(); }
    var post_status = $.post( post_path, json_fData )
    .done(function(post_data) {
      $('#fld_submit_btn').prop('value','Submit Form');
      $('#fs_submitForm').get(0).scrollIntoView();
      $('#feedbackOnForm').html(customPostMsg);
      $('#feedbackOnForm').append(post_data);
      if (!($('.allow-retry').length)) {
        $('#fld_captcha, #fld_submit_btn, .noprint').hide();
        $('#fs_submitForm legend').text('You may print a copy of this for your records.');
      }
    })
    .fail(function() { alert( 'There was an error with this request.' ); });
  }

});
// *** END MAIN FUNCTION ------------------------------------------------------ *
/*! -- Copyright (c) 2017-2020 Mootly Obviate -- See /LICENSE.md -------------- */
