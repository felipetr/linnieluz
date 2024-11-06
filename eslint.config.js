// eslint.config.js
module.exports = [
  {
    files: ['src/**/*.js', 'dist/**/*.php'],
    ignores: ['**/vendor/**/*'],
    languageOptions: {
      ecmaVersion: 12,
      sourceType: 'module',
      globals: {
        window: 'readonly',
      },
    },
    rules: {
      'no-console': 'off',
      'indent': ['error', 4],
      'linebreak-style': ['error', 'unix'],
      'no-unused-vars': ['warn'],
      'no-magic-numbers': ['warn'],
      'prefer-const': ['warn'],
      'eqeqeq': ['error', 'always'],
    },
  },
];
