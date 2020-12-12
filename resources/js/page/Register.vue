<template>
    <div class="uk-container">
        <div class="uk-grid uk-flex-center uk-flex-middle" style="height: 100vh">
            <div>
                <div class="uk-card uk-card-default uk-card-body" v-bind:style="{ width: 500 + 'px' }">
                    <form>
                        <fieldset class="uk-fieldset">

                            <legend class="uk-legend">Register</legend>

                            <div class="uk-alert-danger" uk-alert v-if="error">
                                <p>{{error}}</p>
                            </div>

                            <div class="uk-margin">
                                <div class="uk-inline uk-width-1-1">
                                    <span class="uk-form-icon" uk-icon="icon: user"></span>
                                    <input :class="{ 'uk-input': true, 'uk-form-danger' : formValidation.email != ''}" type="text" placeholder="Email" v-model="email">
                                </div>
                                <div v-if="formValidation.email != ''" class="uk-text-danger">{{formValidation.email}}</div>
                            </div>

                            <div class="uk-margin">
                                <div class="uk-inline uk-width-1-1">
                                    <span class="uk-form-icon" uk-icon="icon: lock"></span>
                                    <input :class="{ 'uk-input': true, 'uk-form-danger' : formValidation.password != ''}" type="password" placeholder="Password" v-model="password">
                                </div>
                                <div v-if="formValidation.password != ''" class="uk-text-danger">{{formValidation.password}}</div>
                            </div>

                            <div class="uk-margin">
                                <div class="uk-inline uk-width-1-1">
                                    <input :class="{ 'uk-input': true, 'uk-form-danger' : formValidation.name != ''}"  type="text" placeholder="Fullname" v-model="name">
                                </div>
                                <div v-if="formValidation.name != ''" class="uk-text-danger">{{formValidation.name}}</div>
                            </div>

                            <div class="uk-margin">
                                <div class="uk-inline uk-width-1-1">
                                    <input :class="{ 'uk-input': true, 'uk-form-danger' : formValidation.companyName != ''}"  type="text" placeholder="Company Name" v-model="companyName">
                                </div>
                                <div v-if="formValidation.companyName != ''" class="uk-text-danger">{{formValidation.companyName}}</div>
                            </div>

                            <div class="uk-margin">
                                <div class="uk-inline uk-width-1-1">
                                    <input :class="{ 'uk-input': true, 'uk-form-danger' : formValidation.address != ''}"  type="text" placeholder="Address" v-model="address">
                                </div>
                                <div v-if="formValidation.address != ''" class="uk-text-danger">{{formValidation.address}}</div>
                            </div>

                            <div class="uk-margin">
                                <div class="uk-inline uk-width-1-1">
                                    <input :class="{ 'uk-input': true, 'uk-form-danger' : formValidation.city != ''}"  type="text" placeholder="City" v-model="city">
                                </div>
                                <div v-if="formValidation.city != ''" class="uk-text-danger">{{formValidation.city}}</div>
                            </div>

                            <div class="uk-margin">
                                <div class="uk-inline uk-width-1-1">
                                    <input :class="{ 'uk-input': true, 'uk-form-danger' : formValidation.phone != ''}"  type="text" placeholder="Phone" v-model="phone">
                                </div>
                                <div v-if="formValidation.phone != ''" class="uk-text-danger">{{formValidation.phone}}</div>
                            </div>

                            <div class="uk-margin">
                                <button @click.prevent="register" class="uk-button uk-button-primary">Register</button>
                                <a class="uk-link-text uk-margin-small-left" :href="baseUrl + '/login'">Cancel</a>
                            </div>

                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import * as _ from 'lodash'
    import queryString from 'querystring'

    export default {
        name: "Register",
        props: [
            'baseUrl'
        ],
        data() {
            return {
                error: '',
                name: '',
                email: '',
                password: '',
                companyName: '',
                companyEmail: '',
                address: '',
                city: '',
                phone: '',
                formValidation: {
                    name: '',
                    email: '',
                    password: '',
                    companyName: '',
                    companyEmail: '',
                    address: '',
                    city: '',
                    phone: '',
                }
            }
        },
        methods: {
            async register() {
                let response = null
                let that = this
                try {
                    response = await axios.post("register",{
                        ...this.$data
                    })
                    UIkit.notification({message: response.data.message, status: 'success'})
                    _.delay(function() {
                        window.location.href = that.baseUrl + '/login';
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
            }
        }
    }
</script>

<style scoped>

</style>