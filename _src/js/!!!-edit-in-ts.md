This is a destination folder for scripts transpiled from TypeScript into ES5/standard JS.

Edits should be done in the /_src/ts/ folder and transpiled from there.

Changes made here will get overwritten next time the code is transpiled.

ES5 should be used if the site has to support Internet Explorer. **This code base no longer supports legacy code for versions below IE 9.**

This folder is a bit redundant, since a minifier set to ES5 will convert ES6 code to ES5 on compression. But it is nice to have a place to read the code.
