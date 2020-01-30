<template>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-9">
                <div class="card card-default">
                    <div class="card-header">Add a new Article</div>
                    <div class="card-body">
                        <div class="alert alert-danger" v-if="has_error && !success">
                            <p v-if="error === 'login_error'">Validation Errors.</p>
                            <p v-else>An internal error occurred. Please verify the data and try again</p>
                        </div>
                        <form autocomplete="off" @submit.prevent="addArticle" method="post">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" id="title" class="form-control" placeholder="Write a title here" v-model="title" required>
                            </div>
                            <div class="form-group">
                                <label for="editor">Content</label>
                                <BlogEditor id="editor" class="editor__edit form-control" v-bind:content="content" @contentUpdated="editorUpdated"></BlogEditor>
                            </div>
                            <button type="submit" class="btn btn-primary">Add</button>
                            <router-link :to="{name: 'admin.dashboard'}" tag="button" class="btn btn-secondary">Go back</router-link>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import BlogEditor from '../components/BlogEditor';
    import ArticleService from '../services/article.js';
    export default {
        data() {
            return {
                title: '',
                body: '',
                tags: [],
                has_error: false,
                error: '',
                content: '',
            }
        },
        methods: {
            addArticle() {
                let app = this;

                ArticleService.addArticle({title: app.title, body: this.content})
                    .then(response => {
                        app.success = true;

                        this.$router.push({name: 'admin.dashboard'});
                    })
                    .catch(error => console.log(error))
            },
            editorUpdated(contentUpdated) {
                this.content = contentUpdated;
            }
        },
        components: {
            BlogEditor
        },
    }
</script>
