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
                    <a href="#" @click="showModalUpdate(item.id)" class="uk-icon-link uk-margin-small-right" uk-icon="pencil"></a>
                    <a href="#" @click="showModalDelete(item.id, item.name)" class="uk-icon-link uk-margin-small-right" uk-icon="trash"></a>
                </td>
            </tr>
            </tbody>
        </table>
        <pagination :page="page" :initial-total-page="initialTotalPage" :arr-page="arrPage" @gotoPage="gotoPage"/>
    </div>
    <div id="modal-create" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <form-category
                    title="Create"
                    :form-default="create"
                    :form-validation="formValidation"
                    @submit="createSubmit">
            </form-category>
        </div>
    </div>
    <div id="modal-update" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <form-category
                    title="Update"
                    :form-default="update"
                    :form-validation="formUpdateValidation"
                    @submit="updateSubmit">
            </form-category>
        </div>
    </div>
    <div id="modal-delete" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <div class="uk-margin">
                <p>Are you sure to delete <strong>{{deleteItem.name}}</strong> ?</p>
            </div>
            <div class="uk-text-right">
                <div v-if="isLoading != true">
                    <button class="uk-button uk-button-default uk-modal-close" type="button">No</button>
                    &nbsp;
                    <button class="uk-button uk-button-primary" type="button" @click="deleteSubmit">Yes</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import * as _ from 'lodash'
    import queryString from 'querystring'
    import Pagination from "../common/Pagination";

    let createDefault = { error: "", name: "" }
    let validationDefault = { name: "" }

    export default {
        name: "CategoryIndex",
        components: {Pagination},
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
                update: { ...createDefault },
                deleteItem: { id: null, name: "" },
                formValidation: {
                    name: ""
                },
                formUpdateValidation: {
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
            async showModalUpdate(id) {
                let that = this
                let response = null;
                try {
                    response = await axios.get("category/detail/" + id)
                    this.update = { error: "", ...response.data }
                    this.formValidation = { ...validationDefault }
                    UIkit.modal("#modal-update").show()
                } catch (error) {
                    console.log(error.response.data);
                }
            },
            showModalDelete(id, name) {
                this.deleteItem = { id: id, name: name }
                UIkit.modal("#modal-delete").show()
            },
            async createSubmit(data) {
                let response = null
                this.isLoading = true
                let that = this
                try {
                    response = await axios.post("category",{ name: data.name })
                    UIkit.notification({message: response.data.message, status: 'success'})
                    UIkit.modal("#modal-create").hide()
                    _.delay(function() {
                        that.gotoPage(1)
                    }, 1000);
                } catch (error) {
                    if (_.has(error, "response.data.validation")) {
                        let validations = error.response.data.validation
                        _.forEach(validations, function(obj, key) {
                            that.formValidation = { ...that.formValidation, [key]:_.values(obj)[0]}
                        })
                    } else {
                        this.create.error = error.response.data.message
                    }
                } finally {
                    this.isLoading = false
                }
            },
            async createSubmit(data) {
                let response = null
                this.isLoading = true
                let that = this
                try {
                    response = await axios.post("category",{ name: data.name })
                    UIkit.notification({message: response.data.message, status: 'success'})
                    UIkit.modal("#modal-create").hide()
                    _.delay(function() {
                        that.gotoPage(1)
                    }, 1000);
                } catch (error) {
                    if (_.has(error, "response.data.validation")) {
                        let validations = error.response.data.validation
                        _.forEach(validations, function(obj, key) {
                            that.formValidation = { ...that.formValidation, [key]:_.values(obj)[0]}
                        })
                    } else {
                        this.create.error = error.response.data.message
                    }
                } finally {
                    this.isLoading = false
                }
            },
            async updateSubmit(data) {
                let response = null
                this.isLoading = true
                let that = this
                try {
                    response = await axios.post("category/"+data.id,{ name: data.name, isActive: data.isActive })
                    UIkit.notification({message: response.data.message, status: 'success'})
                    UIkit.modal("#modal-update").hide()
                    _.delay(function() {
                        that.gotoPage(1)
                    }, 1000);
                } catch (error) {
                    if (_.has(error, "response.data.validation")) {
                        let validations = error.response.data.validation
                        _.forEach(validations, function(obj, key) {
                            that.formUpdateValidation = { ...that.formUpdateValidation, [key]:_.values(obj)[0]}
                        })
                    } else {
                        this.update.error = error.response.data.message
                    }
                } finally {
                    this.isLoading = false
                }
            },
            async deleteSubmit() {
                let response = null
                this.isLoading = true
                let that = this
                try {
                    response = await axios.get("category/delete/"+this.deleteItem.id)
                    UIkit.notification({message: response.data.message, status: 'success'})
                    UIkit.modal("#modal-delete").hide()
                    _.delay(function() {
                        that.gotoPage(1)
                    }, 1000);
                } catch (error) {
                    UIkit.modal("#modal-delete").hide()
                    UIkit.notification({message: error.response.data.message, status: 'danger'})
                } finally {
                    this.isLoading = false
                }
            }
        }
    }
</script>

<style scoped>

</style>