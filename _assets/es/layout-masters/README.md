# Layout Script Masters

## About

This folder contains the master copies of page layout scripts. The ones to be used to should be consoldated into `layout-lib.es6.js` and minified to `layout-lib.es6.min.js`. The minified copy should be moved to the top script folder (`…/_assets/es/`).

For multiple library variations you can either add ones not used across all or most pages to the page individually or create multiple layout libraries. For example, `layout-lib-noTOC.js`.

## Master file

These are the default files into which scripts should be consolidated for inclusion in a page.

* `layout-lib.es6.js` - The list of scripts to be used and their calls.
* `layout-lib.ie.js` - The list of legacy scripts to be used and their calls.

## Existing Scripts

* `stickybar.es6.js` - Keeps a single element from scrolling past the top of the screen.
* `stickybar.ie.js` - Legacy version, pre-ES6.
* `toc-generator.es6.js` - Generates a table of contents.
* `toc-generator.ie.js` - Legacy version, pre-ES6.
