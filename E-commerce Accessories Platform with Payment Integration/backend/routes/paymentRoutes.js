import express from 'express';
import { body } from 'express-validator';
import { createPaymentIntent, handlePaymentSuccess, getOrderHistory, getOrderById } from '../controllers/paymentController.js';
import { protect } from '../middleware/authMiddleware.js';
import { handleValidationErrors } from '../middleware/validationMiddleware.js';
import { paymentLimiter } from '../middleware/rateLimiter.js';

const router = express.Router();

// Validation middleware
const paymentIntentValidation = [
  body('amount').isFloat({ min: 0.01 }).withMessage('Amount must be greater than 0'),
  body('currency').optional().isLength({ min: 3, max: 3 }).withMessage('Currency must be a 3-letter code'),
  body('items').optional().isArray().withMessage('Items must be an array'),
];

const paymentSuccessValidation = [
  body('paymentIntentId').notEmpty().withMessage('Payment intent ID is required'),
  body('items').optional().isArray(),
];

// Routes
router.post('/create-payment-intent', paymentLimiter, paymentIntentValidation, handleValidationErrors, createPaymentIntent);
router.post('/payment-success', protect, paymentLimiter, paymentSuccessValidation, handleValidationErrors, handlePaymentSuccess);
router.get('/orders', protect, getOrderHistory);
router.get('/orders/:id', protect, getOrderById);

export default router;
