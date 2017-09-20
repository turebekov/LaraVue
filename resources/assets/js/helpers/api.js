import axios from 'axios'
import Auth from '../store/auth'
export function get(url) {
    return axios({
        method: 'GET',
        url: url,
        headers: {
            'Authorization': `Bearer ${Auth.state.api_token}`
        }
    })
}

export function post(url, payload) {
    return axios({
        method: 'POST',
        url: url,
        data: payload,
        headers: {
            'Authorization': `Bearer ${Auth.state.api_token}`
        }
    })
}