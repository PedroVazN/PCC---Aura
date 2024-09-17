const express = require('express');
const bodyParser = require('body-parser');
const db = require('./db');
const authRoutes = require('./routes/auth');
const postRoutes = require('./routes/post');
const adminRoutes = require('./routes/admin');

const app = express();
app.use(bodyParser.json());

// Servir arquivos estáticos (HTML, CSS, JS) da pasta 'public'
app.use(express.static('public'));

// Rotas
app.use('/auth', authRoutes);
app.use('/posts', postRoutes);
app.use('/admin', adminRoutes);

// Rota para servir o index.html na raiz "/"
app.get('/', (req, res) => {
  res.sendFile(__dirname + '/public/index.html');
});

const PORT = process.env.PORT || 5000;
app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});
