# Script Conversion

These directions are notes to me for dealing with JS/ES/TS scripts with Atom. Especially because Atom doesn't always play nice with Windows.

As soon as someone ports the Deep Space syntax theme to VS Code, I will consider switching. Or maybe someday I'll get bored and do it myself. This will happen about the same time I find the time to fork one of the modules below for my own purposes, aka, probably never.

## TypeScript > JavaScript

Don't forget to navigate first.

- ES5 - `tsc -p tsconfig.js.json` - config save to `_src/es`
- ES6 - `tsc -p tsconfig.es.json` - config to save to `_src/es`

Technically, you could just convert to ES6 and let the minifier convert that to ES5, and then wouldn't need multiple tsconfig files. On the other hand, this allows you to read the source code as it is about to be compressed to unreadability for both versions of JS. Think of it as documentation.

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

### tsconfig · ES6

```
{
  "compilerOptions": {
    "target"    : "es6",
    "module"    : "commonjs",
    "sourceMap" : true,
    "outDir"    : "../es"
  }
}
```

### tsconfg · JS (ES5)

```
{
  "compilerOptions": {
    "target"    : "es5",
    "module"    : "commonjs",
    "sourceMap" : true,
    "outDir"    : "../js"
  }
}
```
