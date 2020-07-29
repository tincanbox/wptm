module.exports = {
  root: true,
  parser: '@typescript-eslint/parser',
  extends: [
    'eslint:recommended',
    // If you need strict prettier check, comment-back this line.
    //'plugin:prettier/recommended',
  ],
  overrides: [
    // typescript
    {
      files: ["*.ts", "*.tsx"],
      excludedFiles: ["*.test.js", "gatsby-node.js", "gatsby-config.js"],
      plugins: ['@typescript-eslint'],
      extends: [
        'plugin:@typescript-eslint/eslint-recommended',
        'plugin:@typescript-eslint/recommended',
      ],
      rules: {
        '@typescript-eslint/no-explicit-any': 0,
        '@typescript-eslint/member-delimiter-style': 0,
        '@typescript-eslint/interface-name-prefix': 0,
        '@typescript-eslint/no-use-before-define': 0,
      },
    },

    // gatsby config files
    {
      files: ["gatsby-node.js", "gatsby-config.js", "./scripts/**"],
      env: {
        "node": true,
      }
    },

    // test files
    {
      files: ["*.js"],
      plugins: [],
      env: {
        "es6": true,
        "node": true,
        "browser": true
      },
      extends: [
      ],
      parserOptions: {
        ecmaVersion: 2019,
        sourceType: "module",
      }
    }
  ],
  settings: {
  }
}