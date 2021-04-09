# Layout Script Masters

## About

This folder contains the master copies of page layout scripts.

The ones to be used to should be consolidated into `layout-lib.js`. If the code is going to be ised as ES6, used an `es6` infix in the file names, e.g., `layout-lib.es6.js`.

The minified file should be named `layout-lib.min.js`.

The minified copy should be moved to the script folder for this package (`/_assets/js/`).

For multiple library variations you can either add ones not used across all or most pages to the page individually or create multiple layout libraries. For example, `layout-lib-noTOC.js`.

## Master file

These are the default files into which scripts from this folder should be consolidated for inclusion in a page.

| Name                    | Description
| :---                    | :---
| `layout-lib.es6.js`     | The list of ES6 scripts to be used and their calls.
| `layout-lib.js`         | The list of standard JS scripts to be used and their calls.
| `layout-lib.ie.js`      | The list of legacy scripts to be used and their calls.

## Existing Scripts

| Name                    | Description
| :---                    | :---
| `stickybar.es6.js`      | Keeps a single element from scrolling past the top of the screen.
| `stickybar.js`          | Pre-ES6 version.
| `toc-generator.es6.js`  | Generates a table of contents.
| `toc-generator.js`      | Pre-ES6 version.
