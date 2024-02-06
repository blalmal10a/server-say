const mix = require("laravel-mix");

mix.copyDirectory("../app-say/dist/spa", "./public");
mix.copy("../app-say/dist/spa/index.html", "./resources/views/app.blade.php");
