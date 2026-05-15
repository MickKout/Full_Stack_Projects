import { useState } from 'react'
import { CardElement, useStripe, useElements } from '@stripe/react-stripe-js'
import { StripeCardElement } from '@stripe/stripe-js'

interface CheckoutFormProps {
  clientSecret: string
  amount?: number
  onSuccess?: () => void
}

export default function CheckoutForm({ clientSecret, amount = 0, onSuccess }: CheckoutFormProps) {
  const stripe = useStripe()
  const elements = useElements()
  const [message, setMessage] = useState('')
  const [messageType, setMessageType] = useState<'error' | 'success'>('success')
  const [isProcessing, setIsProcessing] = useState(false)

  const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault()

    if (!stripe || !elements) return

    setIsProcessing(true)
    setMessage('')

    try {
      const cardElement = elements.getElement(CardElement)
      if (!cardElement) return

      const { error, paymentIntent } = await stripe.confirmCardPayment(clientSecret, {
        payment_method: {
          card: cardElement,
        },
      })

      if (error) {
        setMessageType('error')
        setMessage(`Payment failed: ${error.message}`)
      } else if (paymentIntent && paymentIntent.status === 'succeeded') {
        setMessageType('success')
        setMessage('🎉 Payment succeeded! Thank you for your purchase.')
        if (onSuccess) {
          onSuccess()
        }
      }
    } catch (err) {
      setMessageType('error')
      setMessage('An error occurred during payment processing')
    } finally {
      setIsProcessing(false)
    }
  }

  return (
    <form onSubmit={handleSubmit} className="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md space-y-4">
      <div>
        <h3 className="text-lg font-semibold text-gray-900 mb-4">Payment Details</h3>
        {amount > 0 && (
          <p className="text-xl font-bold text-primary-600 mb-4">
            Amount: ${(amount / 100).toFixed(2)}
          </p>
        )}
      </div>

      <div className="p-4 border border-gray-300 rounded-lg bg-gray-50">
        <CardElement
          options={{
            style: {
              base: {
                fontSize: '16px',
                color: '#424770',
                '::placeholder': {
                  color: '#aab7c4',
                },
              },
              invalid: {
                color: '#9e2146',
              },
            },
          }}
        />
      </div>

      {message && (
        <div
          className={`p-4 rounded-md ${
            messageType === 'error'
              ? 'bg-red-50 border border-red-200 text-red-700'
              : 'bg-green-50 border border-green-200 text-green-700'
          }`}
        >
          {message}
        </div>
      )}

      <button
        type="submit"
        disabled={!stripe || isProcessing}
        className="btn-primary w-full disabled:opacity-50 disabled:cursor-not-allowed"
      >
        {isProcessing ? 'Processing Payment...' : 'Pay Now'}
      </button>

      <p className="text-xs text-gray-500 text-center">
        Your payment is secure and encrypted with Stripe
      </p>
    </form>
  )
}
