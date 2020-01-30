<template>
    <div class="container">
        <div class="text-right">
            <div class=""><router-link :to="{name: 'admin.add.article'}" class="navbar-brand">Add Article</router-link></div>
        </div>
        <template v-if="articles.length">
            <Article v-for="(article, index) in articles" :title="article.title" v-bind:article="article" :key="article._id" v-on:delete-article="deleteArticle(index)"></Article>
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
        methods: {
            deleteArticle(index) {
                this.articles.splice(index, 1);
            }
        },
        components: {
            Article,
            NoArticle
        }
    }
</script>
