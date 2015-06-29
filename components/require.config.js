var components = {
    "packages": [
        {
            "name": "underscore",
            "main": "underscore-built.js"
        }
    ],
    "shim": {
        "underscore": {
            "exports": "_"
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