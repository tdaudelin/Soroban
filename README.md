# soroban

## Project setup
```
npm install
```

### Compiles and hot-reloads for development
```
npm run serve
```

### Compiles and minifies for production
```
npm run build
```

### Run your unit tests
```
npm run test:unit
```

### Lints and fixes files
```
npm run lint
```

### Generate the WP plugin ready for installation
```
npm run build
```

Update `soroban.php` with the new random IDs generated by the `build` task:
* dist/css/app.{newCssAppId}.css
* dist/js/app.{newJsAppId}.js
* dist/js/chunk-vendors.{newChunkVendorId}.js

Then run the following to generate the ZIP file which can be installed on your WP server as a plugin

```
npm run package
```
### Customize configuration
See [Configuration Reference](https://cli.vuejs.org/config/).
