<template>
    <div id="form-title" class="uk-card uk-card-primary uk-card-body">
        <p>Item <a href="#" @click="showModalCreate" class="uk-icon-button" uk-icon="plus"></a></p>
    </div>
    <div class="main-wrapper">
        <form class="uk-grid-small" uk-grid>
            <div class="uk-width-1-3">
                <input class="uk-input uk-form-small" type="text" placeholder="Name" v-model="filter.name">
            </div>
            <div class="uk-width-1-3">
                <select v-model="filter.category" class="uk-select uk-form-small">
                    <option value="">- Category -</option>
                    <option v-for="option in categories" v-bind:value="option.id">
                        {{ option.name }}
                    </option>
                </select>
            </div>
            <div class="uk-width-1-3">
                <select v-model="filter.type" class="uk-select uk-form-small">
                    <option value="">- Type -</option>
                    <option v-for="(option, index) in types" v-bind:value="index">
                        {{ option }}
                    </option>
                </select>
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
                <th>Category</th>
                <th>Type</th>
                <th>Is Active</th>
                <th>Operation</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
                <td>{{item.name}}</td>
                <td>{{item.category.name}}</td>
                <td>{{$filters.itemTypeName(item.category.type)}}</td>
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
            <form-item
                    title="Create"
                    :form-default="create"
                    :form-validation="formValidation"
                    :categories="categories"
                    :types="types"
                    @submit="createSubmit">
            </form-item>
        </div>
    </div>
    <div id="modal-update" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <form-item
                    title="Update"
                    :form-default="update"
                    :form-validation="formUpdateValidation"
                    :categories="categories"
                    :types="types"
                    @submit="updateSubmit">
            </form-item>
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

    let createDefault = { error: "", name: "", categoryId: "", type: "" }
    let validationDefault = { name: "", categoryId: "", type: "" }

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
                items: window.arrData,
                categories: window.arrCategory,
                types: window.arrType,
                page: this.initialPage,
                arrPage: arrPage,
                filter: window.arrFilter,
                create: { ...createDefault },
                update: { ...createDefault },
                deleteItem: { id: null, name: "" },
                formValidation: { ...validationDefault },
                formUpdateValidation: { ...validationDefault }
            }
        },
        methods: {
            gotoPage(page) {
                let url = this.pageUrl + "?page=" + page
                let params = {
                    page: page,
                    name: this.filter.name,
                    category: this.filter.category,
                    type: this.filter.type
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
                    response = await axios.get("item/detail/" + id)
                    this.update = { error: "", categoryId: response.data?.category?.id, ...response.data }
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
                    response = await axios.post("item",{
                        name: data.name,
                        categoryId: data.categoryId,
                        type: data.type
                    })
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
                    response = await axios.post("item/"+data.id,{
                        name: data.name,
                        categoryId: data.categoryId,
                        type: data.type,
                        isActive: data.isActive
                    })
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
                    response = await axios.get("item/delete/"+this.deleteItem.id)
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