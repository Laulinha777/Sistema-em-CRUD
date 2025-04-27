<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="duvida.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <title>Document</title>
</head>
<body>
<?php
// Verifica se o formulário foi enviado
if (isset($_POST['duvida_email']) && isset($_POST['duvida_mensagem'])) {
  // Processa envio da dúvida
  $email = $_POST['duvida_email'];
  $mensagem = $_POST['duvida_mensagem'];

  // Exibe confirmação do envio
  echo "<div class='duvida-container'><h2>Dúvida enviada com sucesso!</h2></div>";
  echo "<p>Entraremos em contato em breve.</p>";
  echo "<a href='pesquisar.php' class='back-button'>Voltar à pesquisa</a>";
  exit;
}
?>

<!-- Formulário para envio de dúvida -->
<div class="duvida-container">
  <h2>Envie sua dúvida</h2>
  <form method="POST" action="oi.php" class="duvida-form">
    <input type="email" name="duvida_email" placeholder="Seu e-mail" required>
    <textarea name="duvida_mensagem" placeholder="Descreva sua dúvida aqui..." required></textarea>
    <button type="submit">Enviar Dúvida</button>
  </form>
  <a href="index.php" class="back-button">Voltar</a>
</div>

</body>
</html>
