import express from 'express';
import { body } from 'express-validator';
import { registerUser, loginUser, refreshToken, logout } from '../controllers/authController.js';
import { authLimiter } from '../middleware/rateLimiter.js';
import { handleValidationErrors } from '../middleware/validationMiddleware.js';

const router = express.Router();

// Validation middleware
const registerValidation = [
  body('name').trim().notEmpty().withMessage('Name is required'),
  body('email').isEmail().withMessage('Valid email is required'),
  body('password').isLength({ min: 6 }).withMessage('Password must be at least 6 characters'),
];

const loginValidation = [
  body('email').isEmail().withMessage('Valid email is required'),
  body('password').notEmpty().withMessage('Password is required'),
];

const refreshTokenValidation = [
  body('refreshToken').notEmpty().withMessage('Refresh token is required'),
];

// Routes
router.post('/register', authLimiter, registerValidation, handleValidationErrors, registerUser);
router.post('/login', authLimiter, loginValidation, handleValidationErrors, loginUser);
router.post('/refresh-token', refreshTokenValidation, handleValidationErrors, refreshToken);
router.post('/logout', logout);

export default router;
