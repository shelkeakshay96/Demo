define([
    'component'
], function (component) {
    'use strict';

    return function (config) {
        console.log(config); // will output the config object {var1: "hello"}
        component.foo(config.var1); // call function from component.js on data
    }
});