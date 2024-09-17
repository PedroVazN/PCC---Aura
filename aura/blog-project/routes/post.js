const express = require('express');
const router = express.Router();
const db = require('../db');

// Rota para criar post (sem autenticação)
router.post('/create', (req, res) => {
  const { title, content, userId } = req.body;

  const query = 'INSERT INTO posts (user_id, title, content, status) VALUES (?, ?, ?, "pending")';
  db.query(query, [userId, title, content], (err, result) => {
    if (err) {
      return res.status(500).send('Erro ao criar post');
    }
    res.send('Post enviado para aprovação');
  });
});

// Rota para aprovar ou rejeitar posts (sem restrição de admin)
router.put('/approve/:id', (req, res) => {
  const postId = req.params.id;
  const { status } = req.body;

  const query = 'UPDATE posts SET status = ? WHERE id = ?';
  db.query(query, [status, postId], (err, result) => {
    if (err) {
      return res.status(500).send('Erro ao atualizar o status do post');
    }
    res.send(`Post ${status} com sucesso`);
  });
});

// Rota para buscar posts aprovados
router.get('/', (req, res) => {
  const query = 'SELECT * FROM posts WHERE status = "approved"';
  db.query(query, (err, results) => {
    if (err) {
      return res.status(500).send('Erro ao buscar posts');
    }
    res.json(results);
  });
});

// Rota para buscar posts pendentes (sem restrição de admin)
router.get('/pending', (req, res) => {
  const query = 'SELECT * FROM posts WHERE status = "pending"';
  db.query(query, (err, results) => {
    if (err) {
      return res.status(500).send('Erro ao buscar posts pendentes');
    }
    res.json(results);
  });
});

module.exports = router;
