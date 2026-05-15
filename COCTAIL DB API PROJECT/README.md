# 🍸 Cocktail Recipe Finder

A beautiful web application that helps you discover amazing cocktail recipes from around the world using [TheCocktailDB API](https://www.thecocktaildb.com/).

![Cocktail App](https://img.shields.io/badge/Status-Active-success)
![Node.js](https://img.shields.io/badge/Node.js-v18+-green)
![Express](https://img.shields.io/badge/Express-v4.18-blue)

## 📋 Table of Contents

- [Features](#features)
- [Demo](#demo)
- [Technologies Used](#technologies-used)
- [Installation](#installation)
- [How to Run](#how-to-run)
- [Project Structure](#project-structure)
- [API Endpoints](#api-endpoints)
- [How It Works](#how-it-works)
- [Screenshots](#screenshots)
- [Future Enhancements](#future-enhancements)
- [Contributing](#contributing)
- [License](#license)

## ✨ Features

- 🎲 **Random Cocktail** - Get a surprise cocktail recipe with one click
- 🔍 **Search by Name** - Find specific cocktails (e.g., Margarita, Mojito)
- 🥃 **Search by Ingredient** - Discover cocktails based on available ingredients
- 📸 **High-Quality Images** - Beautiful photos of each cocktail
- 📋 **Detailed Recipes** - Complete ingredient lists with measurements
- 🍹 **Step-by-Step Instructions** - Clear mixing instructions
- 📱 **Responsive Design** - Works perfectly on desktop, tablet, and mobile
- 🎨 **Modern UI** - Clean, intuitive interface with smooth animations
- ⚡ **Fast Performance** - Quick API responses and smooth transitions

## 🎬 Demo

The application displays:
- Cocktail name and category
- High-resolution cocktail image
- Type of glass to use
- Whether it's alcoholic or non-alcoholic
- Complete ingredients list with measurements
- Detailed preparation instructions
- Tags (when available)

## 🛠 Technologies Used

### Backend
- **Node.js** - JavaScript runtime
- **Express.js** - Web application framework
- **Axios** - HTTP client for API requests
- **EJS** - Templating engine

### Frontend
- **HTML5** - Structure
- **CSS3** - Styling with custom properties
- **Google Fonts** - Typography (Playfair Display, Poppins)

### API
- **TheCocktailDB API** - Free cocktail database
  - Base URL: `https://www.thecocktaildb.com/api/json/v1/1`
  - Free test API key: `1`

## 📦 Installation

### Prerequisites

Make sure you have the following installed:
- **Node.js** (v14 or higher) - [Download here](https://nodejs.org/)
- **npm** (comes with Node.js)
- **Git** - [Download here](https://git-scm.com/)

### Step 1: Clone the Repository

```bash
git clone https://github.com/yourusername/cocktail-recipe-app.git
cd cocktail-recipe-app
```

### Step 2: Install Dependencies

```bash
npm install
```

This will install:
- `express` - Web framework
- `ejs` - Template engine
- `axios` - HTTP client
- `body-parser` - Parse form data
- `nodemon` (dev dependency) - Auto-restart server on changes

## 🚀 How to Run

### Development Mode (with auto-restart)

```bash
npm run dev
```

The server will automatically restart when you make changes to the code.

### Production Mode

```bash
npm start
```

### Accessing the Application

Once the server is running, open your browser and navigate to:

```
http://localhost:3000
```

You should see the cocktail recipe finder homepage!

## 📁 Project Structure

```
cocktail-recipe-app/
├── public/
│   └── styles/
│       └── main.css          # All CSS styling
├── views/
│   └── index.ejs             # Main template
├── index.js                  # Express server & API routes
├── package.json              # Dependencies and scripts
├── .gitignore                # Git ignore file
└── README.md                 # This file
```

### File Descriptions

- **index.js** - Main server file containing:
  - Express configuration
  - API endpoint handlers
  - Route definitions
  - Helper functions

- **views/index.ejs** - Frontend template with:
  - Search forms
  - Cocktail display area
  - Error handling
  - Responsive layout

- **public/styles/main.css** - Complete styling:
  - Custom CSS properties (variables)
  - Responsive design
  - Animations
  - Print styles

## 🔌 API Endpoints

### Server Routes

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/` | Home page (displays random cocktail) |
| POST | `/random` | Get a new random cocktail |
| POST | `/search/name` | Search cocktail by name |
| POST | `/search/ingredient` | Search cocktails by ingredient |

### TheCocktailDB API Usage

The application uses these API endpoints:

```javascript
// Random cocktail
GET https://www.thecocktaildb.com/api/json/v1/1/random.php

// Search by name
GET https://www.thecocktaildb.com/api/json/v1/1/search.php?s=margarita

// Filter by ingredient
GET https://www.thecocktaildb.com/api/json/v1/1/filter.php?i=vodka

// Lookup by ID
GET https://www.thecocktaildb.com/api/json/v1/1/lookup.php?i=11007
```

## 🔍 How It Works

### 1. Random Cocktail Flow

```
User clicks "Surprise Me!"
    ↓
POST request to /random
    ↓
Server calls API: /random.php
    ↓
Extract ingredients from response
    ↓
Render page with cocktail data
```

### 2. Search by Name Flow

```
User enters "Mojito"
    ↓
POST request to /search/name
    ↓
Server calls API: /search.php?s=mojito
    ↓
Check if results exist
    ↓
Extract first result
    ↓
Render cocktail or show error
```

### 3. Search by Ingredient Flow

```
User enters "Rum"
    ↓
POST request to /search/ingredient
    ↓
Server calls API: /filter.php?i=rum
    ↓
Get random cocktail from results
    ↓
Fetch full details by ID
    ↓
Render complete cocktail info
```

### 4. Ingredient Extraction

The API returns ingredients in a unique format:

```json
{
  "strIngredient1": "Vodka",
  "strMeasure1": "1 oz",
  "strIngredient2": "Lime Juice",
  "strMeasure2": "0.5 oz",
  ...
  "strIngredient15": null,
  "strMeasure15": null
}
```

Our `extractIngredients()` function:
1. Loops through all 15 possible slots
2. Checks if ingredient exists
3. Pairs ingredient with its measurement
4. Returns clean array of ingredients

## 📸 Screenshots

### Home Page with Random Cocktail
- Clean header with app title
- Three search cards (Random, By Name, By Ingredient)
- Large cocktail image
- Complete recipe details

### Search Results
- Highlighted search term
- Cocktail matching criteria
- All recipe information
- Responsive layout

### Mobile View
- Single column layout
- Touch-friendly buttons
- Readable text
- Optimized images

## 🚨 Error Handling

The application handles various error scenarios:

1. **API Connection Failures**
   - Shows user-friendly error message
   - Logs detailed error to console
   - Allows retry

2. **No Results Found**
   - Clear message indicating no matches
   - Suggests trying different search
   - Maintains UI stability

3. **Network Issues**
   - Catches network errors
   - Prevents application crash
   - Displays helpful feedback

## 🧪 Testing the Application

### Test Scenarios

1. **Random Cocktail**
   - Click "Surprise Me!" button
   - Verify cocktail loads
   - Check image displays
   - Verify ingredients list

2. **Search by Name**
   - Try: "Margarita", "Mojito", "Old Fashioned"
   - Test partial matches
   - Test non-existent cocktails
   - Verify error messages

3. **Search by Ingredient**
   - Try: "Vodka", "Rum", "Gin", "Tequila"
   - Test uncommon ingredients
   - Verify random selection works
   - Check full details load

4. **Responsive Design**
   - Resize browser window
   - Test on mobile device
   - Check tablet view
   - Verify all features work

## 🔧 Configuration

### Changing the Port

Edit `index.js`:

```javascript
const port = 3000; // Change to your preferred port
```

### API Key

Currently using the free test key (`1`). For production:

1. Visit [TheCocktailDB](https://www.thecocktaildb.com/)
2. Sign up for a production API key
3. Add to your configuration

## 🚀 Deployment

### Deploy to Heroku

1. Create `Procfile`:
   ```
   web: node index.js
   ```

2. Deploy:
   ```bash
   heroku create your-app-name
   git push heroku main
   ```

### Deploy to Vercel

1. Install Vercel CLI:
   ```bash
   npm i -g vercel
   ```

2. Deploy:
   ```bash
   vercel
   ```

### Deploy to Railway

1. Connect your GitHub repo
2. Select Node.js environment
3. Deploy automatically

## 💡 Future Enhancements

- [ ] Save favorite cocktails
- [ ] Create shopping list from ingredients
- [ ] Filter by multiple ingredients
- [ ] Sort by popularity/rating
- [ ] Share cocktails on social media
- [ ] Print-friendly recipe cards
- [ ] Dark mode toggle
- [ ] Multi-language support
- [ ] Cocktail of the day feature
- [ ] User-submitted recipes

## 🐛 Troubleshooting

### Port Already in Use

```bash
# Kill process on port 3000
lsof -ti:3000 | xargs kill -9
```

### npm install fails

```bash
# Clear cache and reinstall
npm cache clean --force
rm -rf node_modules package-lock.json
npm install
```

### Styles not loading

1. Check `public` folder exists
2. Verify CSS file path: `public/styles/main.css`
3. Clear browser cache (Ctrl+Shift+R)

### API not responding

1. Check internet connection
2. Verify API URL is correct
3. Check console for error messages

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the ISC License.

## 👏 Acknowledgments

- **TheCocktailDB** - For providing the free API
- **Google Fonts** - For beautiful typography
- **Express.js** - For the awesome framework
- **The Node.js Community** - For excellent tools and libraries

## 📧 Contact

Your Name - your.email@example.com

Project Link: [https://github.com/yourusername/cocktail-recipe-app](https://github.com/yourusername/cocktail-recipe-app)

---

**Enjoy discovering new cocktails! 🍸 Drink responsibly!**

*Last updated: 2024*
