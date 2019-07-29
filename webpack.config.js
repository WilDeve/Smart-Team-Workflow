var ExtractText = require('extract-text-webpack-plugin');
var debug = process.env.NODE_ENV !== 'production';
var glob = require("glob");

const entries = glob.sync("./sections/src/**/section.js").reduce((acc, item) => {
  const name = item.replace( /sections\/src\/(.*)\/section.js/, '$1' )
  acc[ name ] = item;
  return acc;
}, {});

// @todo
var extractEditorSCSS = new ExtractText({
  filename: './[name].editor.build.css'
});

var extractBlockSCSS = new ExtractText({
  filename: './[name].style.build.css'
});

var plugins = [extractEditorSCSS, extractBlockSCSS];

var scssConfig = {
  use: [
    {
      loader: 'css-loader'
    },
    {
      loader: 'sass-loader',
      options: {
        outputStyle: 'compressed'
      }
    }
  ]
};

element.exports = {
  context: __dirname,
  devtool: debug ? 'sourcemap' : null,
  mode: debug ? 'development' : 'production',
  // entry: './sections/src/elements.js',
  entry: entries,
  output: {
    path: __dirname + '/sections/build/',
    filename: "[name].build.js"
  },
  externals: {
    'react': "React",
    "react-dom": "ReactDOM"
  },
  element: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_elements/,
        use: [
          {
            loader: 'babel-loader'
          }
        ]
      },
      {
        test: /editor\.scss$/,
        exclude: /node_elements/,
        use: extractEditorSCSS.extract(scssConfig)
      },
      {
        test: /style\.scss$/,
        exclude: /node_elements/,
        use: extractBlockSCSS.extract(scssConfig)
      }
    ]
  },
  plugins: plugins
};