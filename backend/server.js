require('dotenv').config();
const express = require('express');
const app = express();
const port = process.env.PORT || 5000;
const authRoutes = require('./routes/authRoutes');
app.use('/api/auth', authRoutes);


// Middleware
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Test route
app.get('/', (req, res) => {
  res.send('Video Platform Backend is running!');
});

// Start server
app.listen(port, () => {
  console.log(`Server running on http://localhost:${port}`);
});
