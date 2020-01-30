<template>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-9">
                <div class="card card-default">
                    <div class="card-header">Update Article {{ article.title }}</div>
                    <div class="card-body">
                        <form autocomplete="off" @submit.prevent="updateArticle" method="post">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" id="title" class="form-control" placeholder="Write a title here" v-model="article.title" required>
                            </div>
                            <div class="form-group">
                                <label for="editor">Content</label>
                                <BlogEditor id="editor" class="editor__edit form-control" v-if="content !== ''" v-bind:content="content" @contentUpdated="editorUpdated"></BlogEditor>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <router-link :to="{name: 'admin.dashboard'}" tag="button" class="btn btn-secondary">Go back</router-link>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import BlogEditor from "../components/BlogEditor";
    import ArticleService from '../services/article.js';
    export default {
        data() {
            return {
                article: [],
                content: '',
            }
        },
        methods: {
            updateArticle() {
                let app = this;

                ArticleService.updateArticle(app.article._id, {title: app.article.title, body: app.content})
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
        created() {
            ArticleService.getArticle(this.$route.params.articleId)
                .then(article => {
                    this.article = article.data;
                    this.content = this.article.body;
                })
                .catch(error => console.log(error))
        },
        components: {
            BlogEditor
        }
    }
</script>
