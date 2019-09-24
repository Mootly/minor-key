/* --- checkOn.js ------------------------------------------------------------- *
 * checkOn takes a variable of any type and writes it the the browser console.  *
 * use mpf_checkOn(dataElement);
 * --- Revision History ------------------------------------------------------- *
 * 2019-09-24 | Coped to ECMAScript folder
 * ---------------------------------------------------------------------------- */
function mpf_checkOn(someData) {
  someJSON = JSON.stringify(someData);
  console.dir(someData);
}
/*! -- Copyright (c) 2019 Mootly Obviate -- See /LICENSE.md ------------------- */
