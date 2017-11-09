var components = {
    "packages": [
        {
            "name": "ekko-lightbox",
            "main": "ekko-lightbox-built.js"
        },
        {
            "name": "jplayer",
            "main": "jplayer-built.js"
        },
        {
            "name": "holder",
            "main": "holder-built.js"
        },
        {
            "name": "bootstrap-switch",
            "main": "bootstrap-switch-built.js"
        }
    ],
    "shim": {
        "jplayer": {
            "deps": [
                "jquery"
            ]
        },
        "bootstrap-switch": {
            "exports": "BootstrapSwitch"
        }
    },
    "baseUrl": "components"
};
if (typeof require !== "undefined" && require.config) {
    require.config(components);
} else {
    var require = components;
}
if (typeof exports !== "undefined" && typeof module !== "undefined") {
    module.exports = components;
}