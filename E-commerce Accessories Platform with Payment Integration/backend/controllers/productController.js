import { query } from '../config/db.js';

export const getProducts = async (req, res, next) => {
  try {
    const { page = 1, limit = 20 } = req.query;
    const offset = (page - 1) * limit;

    const result = await query(
      'SELECT * FROM products ORDER BY created_at DESC LIMIT $1 OFFSET $2',
      [limit, offset]
    );

    const countResult = await query('SELECT COUNT(*) FROM products');
    const total = parseInt(countResult.rows[0].count);

    res.json({
      success: true,
      data: result.rows,
      pagination: {
        page,
        limit,
        total,
        pages: Math.ceil(total / limit),
      },
    });
  } catch (error) {
    next(error);
  }
};

export const getProductById = async (req, res, next) => {
  const { id } = req.params;

  try {
    const result = await query('SELECT * FROM products WHERE id = $1', [id]);

    if (result.rows.length === 0) {
      return res.status(404).json({
        success: false,
        error: 'Product not found',
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

export const createProduct = async (req, res, next) => {
  const { title, description, price, image_url, stock } = req.body;

  // Validation
  if (!title || !description || !price || stock === undefined) {
    return res.status(400).json({
      success: false,
      error: 'Missing required fields: title, description, price, stock',
    });
  }

  if (isNaN(price) || parseFloat(price) < 0) {
    return res.status(400).json({
      success: false,
      error: 'Price must be a positive number',
    });
  }

  if (isNaN(stock) || parseInt(stock) < 0) {
    return res.status(400).json({
      success: false,
      error: 'Stock must be a non-negative number',
    });
  }

  try {
    const result = await query(
      'INSERT INTO products (title, description, price, image_url, stock) VALUES ($1, $2, $3, $4, $5) RETURNING *',
      [title, description, parseFloat(price), image_url || null, parseInt(stock)]
    );

    res.status(201).json({
      success: true,
      data: result.rows[0],
    });
  } catch (error) {
    next(error);
  }
};

export const updateProduct = async (req, res, next) => {
  const { id } = req.params;
  const { title, description, price, image_url, stock } = req.body;

  try {
    // Check if product exists
    const checkResult = await query('SELECT * FROM products WHERE id = $1', [id]);
    if (checkResult.rows.length === 0) {
      return res.status(404).json({
        success: false,
        error: 'Product not found',
      });
    }

    const result = await query(
      'UPDATE products SET title = COALESCE($1, title), description = COALESCE($2, description), price = COALESCE($3, price), image_url = COALESCE($4, image_url), stock = COALESCE($5, stock), updated_at = NOW() WHERE id = $6 RETURNING *',
      [title || null, description || null, price || null, image_url || null, stock || null, id]
    );

    res.json({
      success: true,
      data: result.rows[0],
    });
  } catch (error) {
    next(error);
  }
};

export const deleteProduct = async (req, res, next) => {
  const { id } = req.params;

  try {
    const checkResult = await query('SELECT * FROM products WHERE id = $1', [id]);
    if (checkResult.rows.length === 0) {
      return res.status(404).json({
        success: false,
        error: 'Product not found',
      });
    }

    await query('DELETE FROM products WHERE id = $1', [id]);

    res.json({
      success: true,
      message: 'Product deleted successfully',
    });
  } catch (error) {
    next(error);
  }
};
