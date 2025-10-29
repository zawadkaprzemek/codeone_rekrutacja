import { ref } from 'vue'
import axios from 'axios'

export function usePayments() {
    const payments = ref([])

    const fetchPayments = async () => {
        try {
            const response = await axios.get('/api/payments')
            payments.value = response.data['hydra:member'] || []
        } catch (error) {
            console.error('Error fetching payments:', error)
        }
    }

    const createPayment = async (amount) => {
        if (!amount) throw new Error("Amount is required")
        try {
            const response = await axios.post('/api/payments', {
                amount: String(amount),
                status: 'new',
            })
            await fetchPayments()
            return response.data
        } catch (error) {
            console.error('Error creating payment:', error)
            throw error
        }
    }

    return {
        payments,
        fetchPayments,
        createPayment,
    }
}
