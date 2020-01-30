<template>
    <div class="container">
        <Article v-for="post in posts" v-bind:article="post"></Article>
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
        components: {
            Article
        }
    }
</script>
