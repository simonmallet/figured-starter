<template>
    <div class="container">
        <template v-if="articles.length">
            <Article v-for="article in articles" v-bind:article="article" :key="article._id"></Article>
        </template>
        <template v-if="seen && !articles.length">
            <NoArticle></NoArticle>
        </template>
    </div>
</template>
<script>
    import NoArticle from "../components/NoArticle";
    import ArticleService from '../services/article.js';
    import Article from '../components/Article.vue'
    export default {
        data() {
            return {
                articles: [],
                seen: false
            }
        },
        created() {
            ArticleService.getArticles()
                .then(articles => {
                    this.articles = articles.data;
                })
                .catch(error => console.log(error))
                .finally(() => {
                    this.seen = true;
                })
        },
        components: {
            Article,
            NoArticle
        }
    }
</script>
