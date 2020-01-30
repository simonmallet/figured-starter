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
                                <label for="body">Content</label>
                                <textarea type="text" id="body" class="form-control" v-model="article.body" required></textarea>
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
    import ArticleService from '../services/article.js';
    export default {
        data() {
            return {
                article: []
            }
        },
        methods: {
            updateArticle() {
                let app = this;

                ArticleService.updateArticle(app.article._id, {title: app.article.title, body: app.article.body})
                    .then(response => {
                        app.success = true;

                        this.$router.push({name: 'admin.dashboard'});
                    })
                    .catch(error => console.log(error))
            }
        },
        created() {
            ArticleService.getArticle(this.$route.params.articleId)
                .then(article => {
                    this.article = article.data;
                })
                .catch(error => console.log(error))
        },
    }
</script>
