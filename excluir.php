<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="styleExclir.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <title>Excluir</title>
  
</head>

<body>
<header>
  <nav class="menu-alterar">
    <li><a href="cadastro.php">Cadastrar</a></li>
    <li><a href="pesquisar.php">Pesquisar</a></li>
    <li><a href="alterar.php">Alterar</a></li>
    <li><a href="excluir.php">Excluir</a></li>
  </nav>
  <div class="btt-duvida">
    <a href="oi.php"><button>Dúvidas?</button></a>
  </div>
</header>

<div class="flex">
  <div class="container">
    <form action="excluir.php" method="POST">
      <h1>Excluir Paciente</h1>
      <input type="number" name="paciCPF" id="paciCPF" placeholder="CPF do Paciente" required>
      <input type="submit" name="buscar" value="Buscar Paciente">
    </form>
    <div class="image-excluir">
      <img src="imagens/medic.svg" alt="imagem de medicina">
    </div>
  </div>
</div>

<?php 
require_once("includes/conectarBDMysqli.php");

$cliente = null;

function buscarPaciente($conexao, $paciCPF) {
  $query = "SELECT paciID, paciNome, paciEmail, paciCPF, DATE_FORMAT(paciDataNascimento, '%d/%m/%Y') AS paciDataNascimento 
            FROM pacientes 
            WHERE paciCPF = ?";
  $stmt = mysqli_prepare($conexao, $query);
  mysqli_stmt_bind_param($stmt, "s", $paciCPF);
  mysqli_stmt_execute($stmt);
  return mysqli_stmt_get_result($stmt);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['buscar'])) {
    $paciCPF = $_POST['paciCPF'] ?? null;
    $consulta = buscarPaciente($conexao, $paciCPF);

    if (mysqli_num_rows($consulta) > 0) {
      $cliente = mysqli_fetch_assoc($consulta);
    } else {
      echo "<p align='center'>Paciente com CPF ($paciCPF) não encontrado.</p>";
    }
  }

  if (isset($_POST['confirmar_exclusao'])) {
    $paciID = $_POST['paciID'] ?? null;
    if ($paciID) {
      $deleteQuery = "DELETE FROM pacientes WHERE paciID = ?";
      $stmt = mysqli_prepare($conexao, $deleteQuery);
      mysqli_stmt_bind_param($stmt, "i", $paciID);
      mysqli_stmt_execute($stmt);

      if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "<p align='center'>Paciente removido com sucesso!</p>";
      } else {
        echo "<p align='center'>Erro ao remover paciente: " . mysqli_error($conexao) . "</p>";
      }
    }
  }
}
?>

<?php if ($cliente): ?>
<div class="cont">
  <h2>Dados do Paciente</h2>
  <p><strong>Código:</strong> <span><?php echo $cliente['paciID']; ?></span></p>
  <p><strong>Nome:</strong> <span><?php echo $cliente['paciNome']; ?></span></p>
  <p><strong>Email:</strong> <span><?php echo $cliente['paciEmail']; ?></span></p>
  <p><strong>CPF:</strong> <span><?php echo $cliente['paciCPF']; ?></span></p>
  <p><strong>Data de Nascimento:</strong> <span><?php echo $cliente['paciDataNascimento']; ?></span></p>

  <!-- Formulário para confirmar exclusão -->
  <form action="excluir.php" method="POST">
    <input type="hidden" name="paciID" value="<?php echo $cliente['paciID']; ?>">
    <input type="submit" name="confirmar_exclusao" value="Confirmar Exclusão">
  </form>
</div>
<?php endif; ?>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const resultado = document.getElementById("oi");
  if (oi) {
    setTimeout(() => {
      resultado.classList.add("show");
    }, 100);
  }
});
</script>


</body>
</html>
