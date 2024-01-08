const mix = require("laravel-mix");

mix.copyDirectory("../say-app/dist/spa", "./public");
mix.copy("../say-app/dist/spa/index.html", "./resources/views/app.blade.php");
