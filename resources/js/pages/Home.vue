<template>
    <div class="container">
        <Article v-for="article in articles" v-bind:article="article"></Article>
    </div>
</template>
<script>
    import ArticleService from '../services/article.js';
    import Article from '../components/Article.vue'
    export default {
        data() {
            return {
                articles: []
            }
        },
        created() {
            ArticleService.getArticles()
                .then(articles => {
                    this.articles = articles.data;
                })
                .catch(error => console.log(error))
        },
        components: {
            Article
        }
    }
</script>
