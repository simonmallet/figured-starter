<template>
    <div class="container">
        <div>Welcome admin user!</div>
        <Article v-for="post in posts" :title="post.title" :content="post.body" :created_at="post.created_at"></Article>
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
