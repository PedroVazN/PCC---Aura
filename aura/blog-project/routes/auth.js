const express = require('express');
const router = express.Router();
const db = require('../db');
const bcrypt = require('bcryptjs');
const jwt = require('jsonwebtoken');

// Registro de Usuário
router.post('/register', (req, res) => {
  const { username, email, password } = req.body;
  const hashedPassword = bcrypt.hashSync(password, 8);

  const query = `INSERT INTO users (username, email, password) VALUES (?, ?, ?)`;
  db.query(query, [username, email, hashedPassword], (err, result) => {
    if (err) return res.status(500).send('Error on the server.');
    res.status(200).send('User registered successfully.');
  });
});

// Login de Usuário
router.post('/login', (req, res) => {
  const { email, password } = req.body;
  const query = `SELECT * FROM users WHERE email = ?`;

  db.query(query, [email], (err, result) => {
    if (err) return res.status(500).send('Error on the server.');
    if (result.length === 0) return res.status(404).send('No user found.');

    const user = result[0];
    const passwordIsValid = bcrypt.compareSync(password, user.password);

    if (!passwordIsValid) return res.status(401).send('Invalid password.');

    const token = jwt.sign({ id: user.id, role: user.role }, 'supersecret', {
      expiresIn: 86400
    });

    res.status(200).send({ auth: true, token: token });
  });
});

module.exports = router;
