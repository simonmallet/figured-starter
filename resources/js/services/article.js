import axios from 'axios';

export default {
    getArticles () {
        return axios.get('/article')
            .then(response => {
                return response.data;
            })
    }
}
