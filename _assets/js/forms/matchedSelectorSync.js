/* --- Sync matched text and selector fields ---------------------------------- *
 * Classes and IDS need to be matched:                                          *
 *   Field________| ID____________| Class______                                 *
 *   Text field   | [fieldID]     | matchedText                                 *
 *   Selector     | [fieldID]Sel  | matchedSel                                  *
 * --- Revision History ------------------------------------------------------- *
 * 2019-06-24 | Added revision log, cleaned code
 * ---------------------------------------------------------------------------- */
                    // Selector sets text field                                 *
$('select.matchedSel').change(function () {
  var tVal          = this.value;
  var tID           = '#'+$(this).attr('id').slice(0,-3);
  if (tVal == 'invalid') { $(tID).val('') }
  else { $(tID).val(tVal); }
});
                    // Text field sets selector                                 *
$('input.matchedText').change(function () {
  var tVal          = this.value.trim();
  var tID           = '#'+$(this).attr('id')+'Sel';
  if (tVal == '') {
     $(tID).val('invalid')
  } else if ($(tID).find('option[value='+tVal+']').length) {
    $(tID).val(tVal);
  } else {
    $(this).val('');
    $(tID).val('invalid');
  }
});
/*! -- Copyright (c) 2017-2019 Mootly Obviate -- See /LICENSE.md -------------- */
