const express = require('express');
const router = express.Router();
const db = require('../db');

// Aprovação de Posts (Sem restrição de admin)
router.put('/approve/:id', (req, res) => {
  const postId = req.params.id;
  const status = req.body.status; // 'approved' ou 'rejected'
  
  const query = `UPDATE posts SET status = ? WHERE id = ?`;
  
  db.query(query, [status, postId], (err, result) => {
    if (err) {
      return res.status(500).send('Houve um problema ao aprovar o post.');
    }
    res.status(200).send(`Post ${status} com sucesso.`);
  });
});

module.exports = router;
