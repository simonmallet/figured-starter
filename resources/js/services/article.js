import axios from 'axios';

export default {
    getArticles () {
        return axios.get('/article')
            .then(response => {
                return response.data;
            })
    },
    addArticle (data) {
        return axios.post('/article', data)
            .then(response => {
                return response.data;
            })
    }
}
