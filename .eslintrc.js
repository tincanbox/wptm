module.exports = {
  "root": true,
  "overrides": [],
  "extends": [
    "eslint:recommended",
    "plugin:@typescript-eslint/eslint-recommended",
    "plugin:@typescript-eslint/recommended",
    "prettier/@typescript-eslint"
  ],
  "globals": {
    "document": true,
    "window": true,
    "$": true,
  },
  "plugins": [
    "@typescript-eslint"
  ],
  "env": {
    "browser": true,
    "node": true,
    "es6": true
  },
  "parser": "@typescript-eslint/parser",
  "parserOptions": {
    "project": "./tsconfig.json"
  },
  "rules": {}
}