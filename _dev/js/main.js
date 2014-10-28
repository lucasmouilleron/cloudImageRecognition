/////////////////////////////////////////////////////////////////////
// REQUIREJS CONFIG
/////////////////////////////////////////////////////////////////////
require.config({
    paths: {
        "jquery": "libs/vendor/jquery/dist/jquery",
        "bootstrap": "libs/vendor/bootstrap/dist/js/bootstrap.min",
        "console": "libs/vendor/console/console.min",
        "throbber": "libs/vendor/throbber.js/throbber",
        "tools": "libs/tools",

    },
    shim: {
        "bootstrap": ["jquery"],
        "throbber": ["jquery"],
        "tools": ["jquery", "console"]
    }
});

/////////////////////////////////////////////////////////////////////
// ENTRY POINT
/////////////////////////////////////////////////////////////////////
require(["jquery", "tools", "bootstrap"], function($, tools) {
    $(function() {
        //tools.displayMainLoader();
        //setTimeout(function(){tools.hideMainLoader()}, 2000);
        c("ok");
    });
});