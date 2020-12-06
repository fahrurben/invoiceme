<template>
    <div id="form-title" class="uk-card uk-card-primary uk-card-body">
        <p>Item Category <a href="#" @click="showModalCreate" class="uk-icon-button" uk-icon="plus"></a></p>
    </div>
    <div class="main-wrapper">
        <form class="uk-grid-small" uk-grid>
            <div class="uk-width-1-3">
                <input class="uk-input uk-form-small" type="text" placeholder="Name" v-model="filter.name">
            </div>
            <div class="uk-width-1-3">
                <label><input class="uk-radio" type="radio" v-model="filter.status" value=""> All </label>
                <label><input class="uk-radio" type="radio" v-model="filter.status" value="true"> Active </label>
                <label><input class="uk-radio" type="radio" v-model="filter.status" value="false"> Inactive </label>
            </div>
            <div class="uk-width-1-3">
                <button class="uk-button uk-button-primary uk-button-small" @click.prevent="search">Search</button>
            </div>
        </form>

        <table class="uk-table uk-table-striped uk-table-small uk-table-divider">
            <thead>
            <tr>
                <th>Name</th>
                <th>Is Active</th>
                <th>Operation</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in categories" :key="item.id">
                <td>{{item.name}}</td>
                <td>{{item.isActive ? 'Yes' : 'No'}}</td>
                <td>
                    <a href="" class="uk-icon-link" uk-icon="pencil"></a>
                    <a href="" class="uk-icon-link" uk-icon="trash"></a>
                </td>
            </tr>
            </tbody>
        </table>
        <ul v-if="initialTotalPage > 1" class="uk-pagination uk-flex-center" uk-margin>
            <li v-if="page > 1"><a href="#" @click="gotoPage(page-1)"><span uk-pagination-previous></span></a></li>
            <li v-for="(item, index) in arrPage" key="index" :class="{ 'uk-active' : index + 1 == page}">
                <a v-if="(index + 1) == page" href="#" @click="gotoPage(index+1)">{{index+1}}</a>
                <a v-else href="#" @click="gotoPage(index+1)">{{index+1}}</a>
            </li>
            <li v-if="page + 1 < initialTotalPage"><a href="#" @click="gotoPage(page+1)"><span uk-pagination-next></span></a></li>
        </ul>
    </div>
    <div id="modal-create" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <form class="uk-form-horizontal">
                <fieldset class="uk-fieldset">

                    <legend class="uk-legend">Create</legend>

                    <div v-if="create.error != ''"  class="uk-alert-danger" uk-alert>
                        <p>{{create.error}}</p>
                    </div>

                    <div v-if="isLoading != true">

                        <div class="uk-margin">
                            <label class="uk-form-label" for="name">Name <span class="uk-text-danger">*</span></label>
                            <div class="uk-form-controls">
                                <input :class="{ 'uk-input': true, 'uk-form-danger' : formValidation.name != ''}" id="name" type="text" v-model="create.name">
                                <div v-if="formValidation.name != ''" class="uk-text-danger">{{formValidation.name}}</div>
                            </div>
                        </div>

                    </div>

                    <div v-else>
                        <div uk-spinner></div>
                    </div>

                </fieldset>
            </form>
            <div class="uk-text-right">
                <div v-if="isLoading != true">
                    <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
                    &nbsp;
                    <button class="uk-button uk-button-primary" type="button" @click="createSubmit">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import * as _ from 'lodash'
    import queryString from 'querystring'

    let createDefault = { error: "", name: "" }
    let validationDefault = { name: "" }

    export default {
        name: "CategoryIndex",
        props: [
            'initialPage',
            'initialTotalPage',
            'pageUrl',
            'baseUrl'
        ],
        data() {
            let arrPage = _.times(this.initialTotalPage, _.constant(0))
            return {
                isLoading: false,
                categories: window.arrData,
                page: this.initialPage,
                arrPage: arrPage,
                filter: window.arrFilter,
                create: { ...createDefault },
                formValidation: {
                    name: ""
                }
            }
        },
        methods: {
            gotoPage(page) {
                let url = this.pageUrl + "?page=" + page
                let params = {
                  page: page,
                  name: this.filter.name
                };
                if (this.filter.status != "") {
                    params.isActive = this.filter.status;
                }
                window.location.href = this.pageUrl + "?" +queryString.stringify(params);
            },
            search() {
                this.gotoPage(1);
            },
            showModalCreate() {
                this.create = { ...createDefault }
                this.formValidation = { ...validationDefault }
                UIkit.modal("#modal-create").show()
            },
            async createSubmit() {
                let response = null
                this.isLoading = true;
                let that = this
                try {
                    response = await axios.post("category",{ name: this.create.name })
                    UIkit.notification({message: response.data.message, status: 'success'})
                    UIkit.modal("#modal-create").hide()
                    _.delay(function() {
                        that.gotoPage(1);
                    }, 1000);
                } catch (error) {
                    if (_.has(error, "response.data.validation")) {
                        let validations = error.response.data.validation
                        _.forEach(validations, function(obj, key) {
                            that.formValidation = { ...that.formValidation, [key]:_.values(obj)[0]}
                        })
                    } else {
                        this.create.error = error.response.data.message;
                    }
                } finally {
                    this.isLoading = false
                }
            }
        }
    }
</script>

<style scoped>

</style>