import axios from 'axios';

export default {
    getArticles () {
        return axios.get('/article')
            .then(response => {
                return response.data;
            })
    },
    getArticle (articleId) {
        return axios.get('/article/' + articleId)
            .then(response => {
                return response.data;
            })
    },
    addArticle (data) {
        return axios.post('/article', data)
            .then(response => {
                return response.data;
            })
    },
    deleteArticle (articleId) {
        return axios.delete( '/article/' + articleId)
            .then(response => {
                return response.data;
            })
    }
}
