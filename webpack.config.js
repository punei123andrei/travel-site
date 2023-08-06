const path = require("path")
const MiniCssExtractPlugin = require("mini-css-extract-plugin")

module.exports = {
  mode: "development",
  entry: {
    main: "./resources/assets/js/App.js", // Your entry point for JavaScript
    style: "./resources/assets/scss/style.scss" // Your entry point for SCSS
  },
  output: {
    filename: "[name].js", // Output filename for JavaScript
    path: path.resolve(__dirname, "build") // Output directory
  },
  module: {
    rules: [
      {
        test: /\.scss$/,
        use: [MiniCssExtractPlugin.loader, "css-loader", "sass-loader"]
      },
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader",
          options: {
            presets: ["@babel/preset-env"]
          }
        }
      }
    ]
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: "style.css" // Output CSS filename
    })
  ]
}
