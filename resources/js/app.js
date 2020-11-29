import * as Vue from 'vue'
import ButtonCounter from './page/ButtonCounter'
import Login from './page/Login'

window.UIkit = require("uikit")
window.Icons = require("uikit/dist/js/uikit-icons")

UIkit.use(window.Icons)

// Create a Vue application
const app = Vue.createApp({})

// Define a new global component called button-counter
app.component('button-counter', ButtonCounter)
app.component('login', Login)


document.addEventListener('DOMContentLoaded', function(){
    app.mount('body')
}, false)


