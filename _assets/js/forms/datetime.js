/* --- Common Date and Time Functions ----------------------------------------- *
 * Autoset date and time fields with a class of "autofill"
 * Auto-increment time fields with a class of "counttime"
 * - auto-increment checks every 30 seconds.
 * --- Revision History ------------------------------------------------------- *
 * 2019-06-24 | Added revision log, cleaned code
 * ---------------------------------------------------------------------------- */
                    // Manual formatting for cross browser support              *
function mp_getTheDate() {
    var now         = new Date();
    var day         = ("0" + now.getDate()).slice(-2);
    var month       = ("0" + (now.getMonth() + 1)).slice(-2);
    var nowDate     = now.getFullYear()+"-"+(month)+"-"+(day) ;
    return nowDate;
}
function mp_getTheTime() {
    var now         = new Date();
    var hours       = ("0" + now.getHours()).slice(-2);
    var minutes     = ("0" + now.getMinutes()).slice(-2);
    var nowTime     = (hours)+":"+(minutes) ;
    return nowTime;
}
                    // Populate fields                                          *
$('input[type=date]').filter('.autofill').val(mp_getTheDate());
$('input[type=time]').filter('.autofill').val(mp_getTheTime());
                    // Set our timer for time fields                            *
setInterval(function () {
  $('input[type=time]').filter('.counttime').val(mp_getTheTime());
}, 30*1000);

/*! -- Copyright (c) 2017-2019 Mootly Obviate -- See /LICENSE.md -------------- */
