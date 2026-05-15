import express from 'express';
import { body } from 'express-validator';
import { getProducts, getProductById, createProduct, updateProduct, deleteProduct } from '../controllers/productController.js';
import { protect, adminOnly } from '../middleware/authMiddleware.js';
import { handleValidationErrors } from '../middleware/validationMiddleware.js';

const router = express.Router();

// Validation middleware
const createProductValidation = [
  body('title').trim().notEmpty().withMessage('Title is required'),
  body('description').trim().notEmpty().withMessage('Description is required'),
  body('price').isFloat({ min: 0 }).withMessage('Price must be a positive number'),
  body('stock').isInt({ min: 0 }).withMessage('Stock must be a non-negative integer'),
  body('image_url').optional().isURL().withMessage('Invalid image URL'),
];

const updateProductValidation = [
  body('title').optional().trim().notEmpty(),
  body('description').optional().trim().notEmpty(),
  body('price').optional().isFloat({ min: 0 }),
  body('stock').optional().isInt({ min: 0 }),
  body('image_url').optional().isURL(),
];

// Routes
router.get('/', getProducts);
router.get('/:id', getProductById);
router.post('/', protect, adminOnly, createProductValidation, handleValidationErrors, createProduct);
router.put('/:id', protect, adminOnly, updateProductValidation, handleValidationErrors, updateProduct);
router.delete('/:id', protect, adminOnly, deleteProduct);

export default router;
