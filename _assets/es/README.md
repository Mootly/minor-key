# Reworking

This folder is where I am converting all my old JS into ES6 scripts or legacy scripts that no longer use jQuery in favor of native JS.

Rethinking how to organize files as I convert things to ES6 to lighten pages by getting rid of jQuery.

This folder will probably be merged back into `/js/` once the recoding is done.

## Current Folders

This folder should only contain files to be included in the page. They should be minified. All originals should be in a subfolder with an appropriate name.

* **dev-tools** - Quick and dirty tools for development. These should never be included in production.
* **layout-masters** - Scripts that create or alter page layouts.
* **polyfills** - These should maybe be under vendors?

## Scripts

The scripts are broken out into two groups, with infises to note the difference: **ES6** scripts and **IE** (legacy) scripts.

## Calling the Scripts

Whenever possibly scripts should be called as events at the end of the page.

Here is a snippet from the current library:

```javascript
// *** onload operations ------------------------------------------------------ *
window.addEventListener('load', mpf_toc_generator);
// *** onresize operations ---------------------------------------------------- *
// window.addEventListener('resize', mpf_);
// *** onscroll operations ---------------------------------------------------- *
// window.addEventListener('scroll', mpf_);
```

Some useful links on this stuff:

* https://developer.mozilla.org/en-US/docs/Web/API/EventTarget/addEventListener
* https://jsfiddle.net/ghctkLgg/
* https://html-online.com/articles/javascript-stick-html-top-scroll/
