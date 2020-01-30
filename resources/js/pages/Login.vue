<template>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-6">
                <div class="card card-default">
                    <div class="card-header">Admin Login</div>
                    <div class="card-body">
                        <div class="alert alert-danger" v-if="has_error && !success">
                            <p v-if="error === 'login_error'">Validation Errors.</p>
                            <p v-else>Error, unable to connect with these credentials.</p>
                        </div>
                        <form autocomplete="off" @submit.prevent="login" method="post">
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="user@example.com" v-model="email" :autofocus="'autofocus'" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" class="form-control" v-model="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Sign in</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                email: null,
                password: null,
                success: false,
                has_error: false,
                error: ''
            }
        },
        mounted() {
            this.formFocus();
        },
        methods: {
            login() {
                this.$auth.login({
                    data: {
                        email: this.email,
                        password: this.password
                    },
                    success: function() {
                        // handle redirection
                        this.success = true;
                        const redirectTo = 'admin.dashboard';
                        this.$router.push({name: redirectTo});
                    },
                    error: function() {
                        this.has_error = true;
                        this.error = res.response.data.error;
                    },
                    rememberMe: true,
                    fetchUser: true
                })
            },
            formFocus() {
                document.getElementById("email").focus();
            }
        }
    }
</script>
