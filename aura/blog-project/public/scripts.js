// Login
document.getElementById('login-form')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
  
    try {
      const response = await fetch('/auth/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password })
      });
  
      const data = await response.json();
  
      if (data.token) {
        localStorage.setItem('token', data.token); // Armazena o token
        alert('Login realizado com sucesso!');
        window.location.href = '/'; // Redireciona para a página inicial
      } else {
        alert('Login falhou: ' + data.message);
      }
    } catch (error) {
      alert('Erro ao realizar login: ' + error.message);
    }
  });
  
  // Registro
  document.getElementById('register-form')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
  
    try {
      const response = await fetch('/auth/register', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username, email, password })
      });
  
      const data = await response.text();
  
      alert(data);
      window.location.href = '/login.html'; // Redireciona para a página de login
    } catch (error) {
      alert('Erro ao registrar usuário: ' + error.message);
    }
  });
  
  // Criação de Post
  document.getElementById('create-post-form')?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const title = document.getElementById('title').value;
    const content = document.getElementById('content').value;
  
    const token = localStorage.getItem('token');
  
    try {
      const response = await fetch('/posts/create', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'x-access-token': token
        },
        body: JSON.stringify({ title, content })
      });
  
      const data = await response.text();
  
      alert(data);
      window.location.href = '/'; // Redireciona para a página inicial
    } catch (error) {
      alert('Erro ao criar post: ' + error.message);
    }
  });
  
  // Carregar Posts Aprovados
  async function loadApprovedPosts() {
    try {
      const response = await fetch('/posts');
      const posts = await response.json();
  
      const postsContainer = document.getElementById('posts-container');
      postsContainer.innerHTML = '';
  
      posts.forEach(post => {
        const postElement = document.createElement('div');
        postElement.classList.add('post');
        postElement.innerHTML = `<h3>${post.title}</h3><p>${post.content}</p>`;
        postsContainer.appendChild(postElement);
      });
    } catch (error) {
      const postsContainer = document.getElementById('posts-container');
      postsContainer.innerHTML = '<p>Erro ao carregar posts.</p>';
      console.error('Error fetching posts:', error);
    }
  }
  
  if (document.getElementById('posts-container') && !window.location.pathname.includes('admin-panel')) {
    loadApprovedPosts();
  }
  
  // Admin - Aprovar/Rejeitar Posts
  async function loadPendingPosts() {
    const token = localStorage.getItem('token');
    try {
      const response = await fetch('/admin/pending', {
        headers: {
          'x-access-token': token
        }
      });
      const posts = await response.json();
  
      const postsContainer = document.getElementById('posts-container');
      postsContainer.innerHTML = '';
  
      posts.forEach(post => {
        const postElement = document.createElement('div');
        postElement.classList.add('post');
        postElement.innerHTML = `
          <h3>${post.title}</h3>
          <p>${post.content}</p>
          <button onclick="approvePost(${post.id}, 'approved')">Aprovar</button>
          <button onclick="approvePost(${post.id}, 'rejected')">Rejeitar</button>
        `;
        postsContainer.appendChild(postElement);
      });
    } catch (error) {
      const postsContainer = document.getElementById('posts-container');
      postsContainer.innerHTML = '<p>Erro ao carregar posts pendentes.</p>';
      console.error('Error fetching pending posts:', error);
    }
  }
  
  async function approvePost(postId, status) {
    const token = localStorage.getItem('token');
    try {
      const response = await fetch(`/admin/approve/${postId}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'x-access-token': token
        },
        body: JSON.stringify({ status })
      });
  
      const data = await response.text();
      alert(data);
      if (window.location.pathname.includes('admin-panel')) {
        loadPendingPosts();
      }
    } catch (error) {
      alert('Erro ao atualizar status do post: ' + error.message);
    }
  }
  
  if (document.getElementById('posts-container') && window.location.pathname.includes('admin-panel')) {
    loadPendingPosts();
  }
  