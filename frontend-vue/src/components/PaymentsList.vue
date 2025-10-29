<template>
  <div>
    <input v-model="newAmount" type="number" placeholder="Enter the amount" />
    <button @click="createPayment">Add Payment</button>

    <ul>
      <li v-for="payment in payments" :key="payment.id">
        #{{ payment.id }} - {{ payment.amount }} PLN - {{ payment.status }}
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useAuth } from '../composables/useAuth'

const payments = ref([])
const newAmount = ref('100')
const { login, getAuthHeader } = useAuth()

const fetchPayments = async () => {
  const response = await axios.get('/api/payments', {
    headers: getAuthHeader()
  })
  payments.value = response.data['hydra:member'] || []
}

const createPayment = async () => {
  if (!newAmount.value) return alert("Enter the amount!")
  await axios.post('/api/payments', {
    amount: String(newAmount.value),
    status: 'new'
  }, { headers: getAuthHeader() })
  await fetchPayments()
  newAmount.value = ''
}

onMounted(async () => {
  await login()
  await fetchPayments()
})

</script>
