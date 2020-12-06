import * as Vue from 'vue'

import Pagination from './page/common/Pagination';

import ButtonCounter from './page/ButtonCounter'
import Login from './page/Login'
import CategoryIndex from './page/category/Index'
import FormCategory from './page/category/Form'

window.UIkit = require("uikit")
window.Icons = require("uikit/dist/js/uikit-icons")

UIkit.use(window.Icons)

// Create a Vue application
const app = Vue.createApp({})

app.component('Pagination', Pagination)

app.component('button-counter', ButtonCounter)
app.component('login', Login)
app.component('category-index', CategoryIndex)
app.component('form-category', FormCategory)

document.addEventListener('DOMContentLoaded', function(){
    app.mount('#mainWrapper')
}, false)


