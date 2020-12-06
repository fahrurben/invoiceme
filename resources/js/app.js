import * as Vue from 'vue'
import ButtonCounter from './page/ButtonCounter'
import Login from './page/Login'
import CategoryIndex from './page/category/Index'

window.UIkit = require("uikit")
window.Icons = require("uikit/dist/js/uikit-icons")

UIkit.use(window.Icons)

// Create a Vue application
const app = Vue.createApp({})

// Define a new global component called button-counter
app.component('button-counter', ButtonCounter)
app.component('login', Login)
app.component('category-index', CategoryIndex)

document.addEventListener('DOMContentLoaded', function(){
    app.mount('#mainWrapper')
}, false)


