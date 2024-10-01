<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registre-se</title>

<body>
    <form action="index.php?p=cadastrar" method="POST">
        <label for="nome">Nome</label>
        <input type="text" value="" required name="nome">

        <label for="sobrenome">Sobrenome</label>
        <input type="text" value="" required name="sobrenome">

        <label for="email">Email</label>
        <input type="email" value="" required name="email">

        <label for="senha">Senha</label>
        <input type="text" value="" required name="password">

        <label for="rsenha">Repita a Senha</label>
        <input type="text" value="" required name="rsenha">
        
        <label for="niveldeacesso">Nível de Acesso</label>
        <select name="niveldeacesso">
            <option value="">Selecione</option>      
            <option value="1">Básico</option>
            <option value="2">Admin</option> 
        </select>

        <input type="submit" value="Salvar" name="Confirmar">
    </form>


</body>

</html>