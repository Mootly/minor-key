/* --- matchedSelectorSync.js ------------------------------------------------- *
 * Sync matched selector and text fields                                        *
 * Classes and IDS need to be matched:                                          *
 *   Field________| ID__________| Class______                                   *
 *   Text field   | fieldID     | matchedText                                   *
 *   Selector     | fieldIDSel  | matchedSel                                    *
 * ---------------------------------------------------------------------------- */
                    // Selector sets text field                                 *
$('select.matchedSel').change(function () {
  var tVal = this.value;
  var tID  = '#'+$(this).attr('id').slice(0,-3);
  if (tVal == 'invalid') { $(tID).val('') }
  else { $(tID).val(tVal); }
});
                    // Text field sets selector                                 *
$('input.matchedText').change(function () {
  var tVal = this.value.trim();
  var tID  = '#'+$(this).attr('id')+'Sel';
  if (tVal == '') {
     $(tID).val('invalid')
  } else if ($(tID).find('option[value='+tVal+']').length) {
    $(tID).val(tVal);
  } else {
    $(this).val('');
    $(tID).val('invalid');
//  procError('form',$(this).attr('id'),'Please enter a valid value for this field.');
  }
});
