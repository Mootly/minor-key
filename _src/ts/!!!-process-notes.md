# Script Conversion

These directions are notes to me for dealing with JS/ES/TS scripts with Atom. Especially because Atom doesn't always play nice with Windows.

As soon as someone ports the Deep Space syntax theme to VS Code, I will consider switching. Or maybe someday I'll get bored and do it myself. This will happen about the same time I find the time to fork one of the modules below for my own purposes, aka, probably never.

## TypeScript > JavaScript

Don't forget to navigate first.

- ES6 - `tsc -p tsconfig.[library].es.json` - config to save to `_src/es`
- ES5 - `tsc -p tsconfig.[library].js.json` - config to save to `_src/js`

Technically, you could just convert to ES6 and let the minifier convert that to ES5. On the other hand, this allows you to read the source code as it is about to be compressed to unreadability for both versions of JS. Think of it as documentation. Or just skip it and go the ES6 route.

## Minify

There are two minify modules installed. They do different things.
- `atom-minify` - Minifies both JS and CSS
- `atom-uglfy-es` - Minifies ES (specifically handles ES6)

To minify ES5, in the tree view:
1. right click on the file,
2. select "Minify".

For ES5, JS minification should be set to minify to `_assets\js\*.min.js`. The current configuration converts any ES6 syntax to ES5 on compression.

To minify ES6, in the file tab list (is in the tree view, but doesn't work there):
1. right click on the file,
2. select "Minify Javascript".

The atom uglify module doesn't support changing the path, so you have to drag and drop it is the `_assets\es\` folder.

### Command Line Minify · ES6

The Atom uglify module uses Uglify-JS@3. This minifies while preserving ES6 syntax. It doesn't support wildcards. This is the command structure for invoking it on this site.

- `uglifyjs *[file]*.js -c -o ../../_assets/es/*[file]*.min.js'

## Config files

Our config files concatenate library file sets into on single file for compressing and inclusion.

### Current Configs

For easy cutting and pasting.

- `./layout-lib`
  - ES6: `tsc -p tsconfig.layout.es.json`
  - ES5: `tsc -p tsconfig.layout.js.json`


### tsconfig · ES6

```
{
  "compilerOptions": {
    "target"    : "ES6",
    "module"    : "System",
    "sourceMap" : false,
    "outFile"   : "../es/[library name].js"
  },
  "include"       : [
    "./[library path]/[file].ts",
    .
    .
    .
  ]
}
```

### tsconfg · JS (ES5)

```
{
  "compilerOptions": {
    "target"    : "ES5",
    "module"    : "System",
    "sourceMap" : false,
    "outFile"   : "../js/[library name].js"
  },
  "include"       : [
    "./[library path]/[file].ts",
    .
    .
    .
  ]
}
```
