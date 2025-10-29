import { ref } from 'vue'
import axios from 'axios'

const token = ref('')

export function useAuth() {
    const login = async () => {
        const response = await axios.post('/auth', {
            email: 'konto@test.pl',
            password: 'CodeOne123'
        })
        token.value = response.data.token
    }

    const getAuthHeader = () => ({
        Authorization: `Bearer ${token.value}`,
    })

    return { token, login, getAuthHeader }
}
