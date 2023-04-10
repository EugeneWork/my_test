import axios from 'axios'

let token=localStorage.getItem('api_token');
if (token){
    axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
}
export default axios;
