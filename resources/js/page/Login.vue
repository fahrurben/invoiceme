<template>
    <div class="uk-container">
        <div class="uk-grid uk-flex-center uk-flex-middle" style="height: 100vh">
            <div>
                <div class="uk-card uk-card-default uk-card-body" v-bind:style="{ width: 500 + 'px' }">
                    <form>
                        <fieldset class="uk-fieldset">

                            <legend class="uk-legend">Login</legend>

                            <div class="uk-alert-danger" uk-alert v-if="error">
                                <p>{{error}}</p>
                            </div>

                            <div class="uk-margin">
                                <div class="uk-inline uk-width-1-1">
                                    <span class="uk-form-icon" uk-icon="icon: user"></span>
                                    <input class="uk-input" type="text" placeholder="Email" v-model="email">
                                </div>
                            </div>

                            <div class="uk-margin">
                                <div class="uk-inline uk-width-1-1">
                                    <span class="uk-form-icon" uk-icon="icon: lock"></span>
                                    <input class="uk-input" type="password" placeholder="Password" v-model="password">
                                </div>
                            </div>

                            <div class="uk-margin uk-clearfix">
                                <button @click.prevent="login" class="uk-button uk-button-primary uk-float-right">Login</button>
                                <a class="uk-link-text uk-float-left uk-margin-small-top" :href="baseUrl + '/register'">Register</a>
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

    export default {
        name: "Login",
        props: [
            'baseUrl'
        ],
        data() {
            return {
                email: '',
                password: '',
                error: '',
            }
        },
        methods: {
            async login() {
                let response = null
                try {
                    response = await axios.post("login",
                        { email: this.email, password: this.password })

                    // Todo: Remove this hardcode
                    window.location = "/"
                } catch (error) {
                    this.error = error.response.data.message;
                }
            }
        }
    }
</script>

<style scoped>

</style>