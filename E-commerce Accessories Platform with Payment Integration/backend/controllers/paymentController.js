import Stripe from 'stripe';
import { query } from '../config/db.js';
import dotenv from 'dotenv';

dotenv.config();
const stripe = new Stripe(process.env.STRIPE_SECRET_KEY);

export const createPaymentIntent = async (req, res, next) => {
  const { amount, currency = 'usd', items = [] } = req.body;
  const userId = req.user?.id;

  // Validation
  if (!amount || amount <= 0) {
    return res.status(400).json({
      success: false,
      error: 'Amount must be greater than 0',
    });
  }

  try {
    const paymentIntent = await stripe.paymentIntents.create({
      amount: Math.round(amount * 100), // Convert to cents
      currency,
      automatic_payment_methods: { enabled: true },
      metadata: {
        userId: userId || 'guest',
        items: JSON.stringify(items),
      },
    });

    res.json({
      success: true,
      clientSecret: paymentIntent.client_secret,
      paymentIntentId: paymentIntent.id,
    });
  } catch (error) {
    next(error);
  }
};

export const handlePaymentSuccess = async (req, res, next) => {
  const { paymentIntentId, items = [] } = req.body;
  const userId = req.user?.id;

  if (!paymentIntentId) {
    return res.status(400).json({
      success: false,
      error: 'Payment intent ID is required',
    });
  }

  try {
    // Retrieve payment intent from Stripe
    const paymentIntent = await stripe.paymentIntents.retrieve(paymentIntentId);

    if (paymentIntent.status !== 'succeeded') {
      return res.status(400).json({
        success: false,
        error: 'Payment has not succeeded',
      });
    }

    // Create order in database
    const result = await query(
      'INSERT INTO orders (user_id, amount, stripe_payment_intent_id, status, items) VALUES ($1, $2, $3, $4, $5) RETURNING *',
      [
        userId,
        paymentIntent.amount / 100, // Convert back from cents
        paymentIntentId,
        'succeeded',
        JSON.stringify(items),
      ]
    );

    res.json({
      success: true,
      message: 'Payment processed successfully',
      order: result.rows[0],
    });
  } catch (error) {
    next(error);
  }
};

export const getOrderHistory = async (req, res, next) => {
  const userId = req.user?.id;

  if (!userId) {
    return res.status(401).json({
      success: false,
      error: 'User not authenticated',
    });
  }

  try {
    const result = await query(
      'SELECT * FROM orders WHERE user_id = $1 ORDER BY created_at DESC',
      [userId]
    );

    res.json({
      success: true,
      data: result.rows,
    });
  } catch (error) {
    next(error);
  }
};

export const getOrderById = async (req, res, next) => {
  const { id } = req.params;
  const userId = req.user?.id;

  try {
    const result = await query(
      'SELECT * FROM orders WHERE id = $1 AND user_id = $2',
      [id, userId]
    );

    if (result.rows.length === 0) {
      return res.status(404).json({
        success: false,
        error: 'Order not found',
      });
    }

    res.json({
      success: true,
      data: result.rows[0],
    });
  } catch (error) {
    next(error);
  }
};
