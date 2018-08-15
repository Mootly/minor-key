/* --- Common Date and Time Functions ----------------------------------------- *
 * Autoset date and time fields with a class of "autofill"
 * Autoincrement time fields with a class of "counttime"
 * - auto increment checks every 10 seconds.
 * ---------------------------------------------------------------------------- */
                    // Manual formatting for cross browser support              ***
function mp_getTheDate() {
    var now         = new Date();
    var day         = ("0" + now.getDate()).slice(-2);
    var month       = ("0" + (now.getMonth() + 1)).slice(-2);
    var today       = now.getFullYear()+"-"+(month)+"-"+(day) ;
    return today;
}
function mp_getTheTime() {
    var now         = new Date();
    var hours       = ("0" + now.getHours()).slice(-2);
    var minutes     = ("0" + now.getMinutes()).slice(-2);
    var today       = (hours)+":"+(minutes) ;
    return today;
}
$('input[type=date]').filter('.autofill').val(mp_getTheDate());
$('input[type=time]').filter('.autofill').val(mp_getTheTime());

setInterval(function () {
  $('input[type=time]').filter('.autofill').val(mp_getTheTime());
}, 10*1000);

/*! -- Copyright (c) 2017-2018 Mootly Obviate -- See /LICENSE.md -------------- */
