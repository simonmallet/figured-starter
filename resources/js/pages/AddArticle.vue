<template>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-9">
                <div class="card card-default">
                    <div class="card-header">Add a new Article</div>
                    <div class="card-body">
                        <ErrorDisplay v-bind:errors="errors"></ErrorDisplay>
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
    import ErrorDisplay from "../components/ErrorDisplay";
    import BlogEditor from '../components/BlogEditor';
    import ArticleService from '../services/article.js';
    import Validator from '../helpers/validator.js';
    export default {
        data() {
            return {
                title: '',
                body: '',
                errors: [],
                content: '',
            }
        },
        methods: {
            addArticle() {
                this.clearErrors();

                if (Validator.isEmptyArticleContent(this.content)) {
                    this.errors.push(Validator.ARTICLE_CANNOT_BE_EMPTY);
                    return;
                }

                ArticleService.addArticle({title: this.title, body: this.content})
                    .then(response => {
                        this.success = true;

                        this.$router.push({name: 'admin.dashboard'});
                    })
                    .catch((error) => console.log(error))
            },
            editorUpdated(contentUpdated) {
                this.content = contentUpdated;
                this.clearErrors();
                if (Validator.isEmptyArticleContent(contentUpdated)) {
                    this.errors.push(Validator.ARTICLE_CANNOT_BE_EMPTY);
                }
            },
            clearErrors() {
                this.errors = [];
            },
        },
        components: {
            ErrorDisplay,
            BlogEditor
        },
    }
</script>
