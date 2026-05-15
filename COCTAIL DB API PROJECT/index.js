/**
 * Cocktail Recipe App - Main Server
 * Using TheCocktailDB API to fetch and display cocktail recipes
 * 
 * API Base URL: https://www.thecocktaildb.com/api/json/v1/1/
 * Free API Key: 1 (test key)
 */

import express from 'express';
import bodyParser from 'body-parser';
import axios from 'axios';

const app = express();
const port = 3000;

// API Configuration
const API_URL = "https://www.thecocktaildb.com/api/json/v1/1";

// Middleware Configuration
app.use(express.static("public")); // Serve static files (CSS, images)
app.use(bodyParser.urlencoded({ extended: true })); // Parse form data
app.set('view engine', 'ejs'); // Set EJS as templating engine

/**
 * Home Route - Display random cocktail on page load
 * GET /
 */
app.get("/", async (req, res) => {
  try {
    // Fetch a random cocktail from the API
    const response = await axios.get(`${API_URL}/random.php`);
    const cocktail = response.data.drinks[0];
    
    // Process ingredients (API stores them as strIngredient1, strIngredient2, etc.)
    const ingredients = extractIngredients(cocktail);
    
    // Render the home page with cocktail data
    res.render("index.ejs", { 
      cocktail: cocktail,
      ingredients: ingredients,
      searchTerm: null,
      error: null
    });
    
  } catch (error) {
    console.error("Error fetching random cocktail:", error.message);
    res.render("index.ejs", { 
      cocktail: null,
      ingredients: [],
      searchTerm: null,
      error: "Failed to load cocktail. Please try again."
    });
  }
});

/**
 * Random Cocktail Route - Get another random cocktail
 * POST /random
 */
app.post("/random", async (req, res) => {
  try {
    const response = await axios.get(`${API_URL}/random.php`);
    const cocktail = response.data.drinks[0];
    const ingredients = extractIngredients(cocktail);
    
    res.render("index.ejs", { 
      cocktail: cocktail,
      ingredients: ingredients,
      searchTerm: null,
      error: null
    });
    
  } catch (error) {
    console.error("Error fetching random cocktail:", error.message);
    res.render("index.ejs", { 
      cocktail: null,
      ingredients: [],
      searchTerm: null,
      error: "Failed to load random cocktail. Please try again."
    });
  }
});

/**
 * Search by Name Route - Find cocktail by name
 * POST /search/name
 */
app.post("/search/name", async (req, res) => {
  const searchTerm = req.body.cocktailName;
  
  try {
    // Search for cocktail by name
    const response = await axios.get(`${API_URL}/search.php`, {
      params: { s: searchTerm }
    });
    
    // Check if any cocktails were found
    if (response.data.drinks && response.data.drinks.length > 0) {
      const cocktail = response.data.drinks[0]; // Get first result
      const ingredients = extractIngredients(cocktail);
      
      res.render("index.ejs", { 
        cocktail: cocktail,
        ingredients: ingredients,
        searchTerm: searchTerm,
        error: null
      });
    } else {
      // No cocktails found
      res.render("index.ejs", { 
        cocktail: null,
        ingredients: [],
        searchTerm: searchTerm,
        error: `No cocktails found matching "${searchTerm}". Try another search!`
      });
    }
    
  } catch (error) {
    console.error("Error searching cocktails:", error.message);
    res.render("index.ejs", { 
      cocktail: null,
      ingredients: [],
      searchTerm: searchTerm,
      error: "Search failed. Please try again."
    });
  }
});

/**
 * Search by Ingredient Route - Find cocktails containing an ingredient
 * POST /search/ingredient
 */
app.post("/search/ingredient", async (req, res) => {
  const ingredient = req.body.ingredient;
  
  try {
    // Search for cocktails by ingredient
    const response = await axios.get(`${API_URL}/filter.php`, {
      params: { i: ingredient }
    });
    
    if (response.data.drinks && response.data.drinks.length > 0) {
      // Get a random cocktail from the results
      const randomIndex = Math.floor(Math.random() * response.data.drinks.length);
      const cocktailPreview = response.data.drinks[randomIndex];
      
      // Fetch full details for the selected cocktail
      const detailsResponse = await axios.get(`${API_URL}/lookup.php`, {
        params: { i: cocktailPreview.idDrink }
      });
      
      const cocktail = detailsResponse.data.drinks[0];
      const ingredients = extractIngredients(cocktail);
      
      res.render("index.ejs", { 
        cocktail: cocktail,
        ingredients: ingredients,
        searchTerm: ingredient,
        error: null
      });
    } else {
      res.render("index.ejs", { 
        cocktail: null,
        ingredients: [],
        searchTerm: ingredient,
        error: `No cocktails found with "${ingredient}". Try another ingredient!`
      });
    }
    
  } catch (error) {
    console.error("Error searching by ingredient:", error.message);
    res.render("index.ejs", { 
      cocktail: null,
      ingredients: [],
      searchTerm: ingredient,
      error: "Search failed. Please try again."
    });
  }
});

/**
 * Helper Function: Extract ingredients and measurements from cocktail object
 * The API stores ingredients as strIngredient1...strIngredient15
 * and measurements as strMeasure1...strMeasure15
 */
function extractIngredients(cocktail) {
  const ingredients = [];
  
  // Loop through all possible ingredient slots (1-15)
  for (let i = 1; i <= 15; i++) {
    const ingredient = cocktail[`strIngredient${i}`];
    const measure = cocktail[`strMeasure${i}`];
    
    // Only add if ingredient exists and is not empty
    if (ingredient && ingredient.trim() !== "") {
      ingredients.push({
        name: ingredient,
        measure: measure ? measure.trim() : "" // Measure might be null
      });
    }
  }
  
  return ingredients;
}

/**
 * Start the Express server
 */
app.listen(port, () => {
  console.log(`🍸 Cocktail Recipe App running on http://localhost:${port}`);
  console.log(`📖 Press Ctrl+C to stop the server`);
});
