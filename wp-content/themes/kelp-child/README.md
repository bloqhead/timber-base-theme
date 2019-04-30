# No more Grunt, only Webpack

## Why? 🤔
Over time, technologies change and things get faster. The slower things get replaced by faster, better things. Webpack has become the buzz word you probably hate by now but there is something to the tool. ⚡️ **It's super goddamn fast**. Grunt has grown to be more than we need and it is far slower at running tasks than Webpack. Not only that, Webpack allows features such as:

* It allows us to use `imports`. We can now import other scripts in when they are needed
* You can write in ES6 and it will automatically get transpiled to ES5. What does this mean? You can write tomorrow's JavaScript today but still compile to something that older browsers (see: Edge, IE) can understand
* You can import CSS into JS which allows us to eventually take advantage of HMR (Hot Module Reloading). For now though, LiveReload is baked right in.

## Get started 🤓
1. Type `npm install` into your command line tool
2. Navigate to `kelp-child` in your command line tool of choice
3. Type `npm run watch` to start Webpack and its file watcher
4. Start coding. Write your Sass and JS as usual.

You should notice that the Webpack compiling reloads much faster than Grunt did on the previous iterations of our theme.

![MAGIC](https://i.imgur.com/YsbKHg1.gif)
