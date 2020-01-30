<template>
    <div class="container">
        <div class="text-right">
            <div class=""><router-link :to="{name: 'admin.add.article'}" class="navbar-brand">Add Article</router-link></div>
        </div>
        <Article v-for="(post, index) in posts" :title="post.title" v-bind:article="post" :key="post._id" v-on:delete-article="deleteArticle(index)"></Article>
    </div>
</template>
<script>
    import ArticleService from '../services/article.js';
    import Article from '../components/Article.vue'
    export default {
        data() {
            return {
                posts: []
            }
        },
        created() {
            ArticleService.getArticles()
                .then(posts => {
                    this.posts = posts.data;
                })
                .catch(error => console.log(error))
        },
        methods: {
            deleteArticle(index) {
                this.posts.splice(index, 1);
            }
        },
        components: {
            Article
        }
    }
</script>
