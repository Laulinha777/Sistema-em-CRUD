
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pesquisar</title>
  <link rel="stylesheet" href="Pesquisarstyle.css">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
<?php
require_once("includes/conectarBDMysqli.php");

$cliente = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paciCPF = $_POST["paciCPF"] ?? null;

    function buscarPaciente($conexao, $paciCPF) {
        $query = "SELECT paciID, paciNome, paciCPF, paciEmail, DATE_FORMAT(paciDataNascimento, '%d/%m/%Y') AS paciDataNascimento FROM pacientes WHERE paciCPF = ?";
        $stmt = mysqli_prepare($conexao, $query);
        mysqli_stmt_bind_param($stmt, "s", $paciCPF); // CPF é string
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }

    $consulta = buscarPaciente($conexao, $paciCPF);
    if (mysqli_num_rows($consulta) > 0) {
        $cliente = mysqli_fetch_assoc($consulta);
    } else {
        echo "<p style='color: white;'>Paciente com CPF <strong>$paciCPF</strong> não encontrado.</p>";
        echo "<a href='pesquisar.php'><button>Voltar</button></a>";
    }
}

// Define se o formulário aparece ou não
$formClass = 'container';
if ($cliente) $formClass .= ' hidden';
?>

<ul class="menus">
  <li><a href="cadastro.php">Cadastrar</a></li>
  <li><a href="pesquisar.php">Pesquisar</a></li>
  <li><a href="alterar.php">Alterar</a></li>
  <li><a href="excluir.php">Excluir</a></li>
  <div class="btt">
    <button onclick="window.location.href='oi.php'">Dúvidas?</button>
  </div>
</ul>

<!-- FORMULÁRIO -->
<div id="form-container" class="<?php echo $formClass; ?>">
  <form method="POST" action="pesquisar.php">
    <h1>Pesquisar Paciente</h1>
    <input type="number" name="paciCPF" id="paciCPF" placeholder="CPF do Paciente" required />
    <input type="submit" value="Pesquisar Paciente" />
    <div class="image-pes">
      <img src="imagens/medic.svg" alt="Ilustração médica">
    </div>
  </form>
</div>

<!-- RESULTADO COM FADE -->
<?php if ($cliente): ?>
<div id="resultado" class="container">
  <h2>Dados do Paciente</h2>
  <p><strong>Código:</strong> <span><?php echo $cliente['paciID']; ?></span></p>
  <p><strong>Nome:</strong> <span><?php echo $cliente['paciNome']; ?></span></p>
  <p><strong>Email:</strong> <span><?php echo $cliente['paciEmail']; ?></span></p>
  <p><strong>CPF:</strong> <span><?php echo $cliente['paciCPF']; ?></span></p>
  <p><strong>Data de Nascimento:</strong> <span><?php echo $cliente['paciDataNascimento']; ?></span></p>

  <a href="alterar.php?paciID=<?php echo $cliente['paciID']; ?>"><button>Alterar</button></a>
  <a href="pesquisar.php"><button>Nova Pesquisa</button></a>
</div>
<?php endif; ?>

<!-- JavaScript -->
<script>
document.addEventListener("DOMContentLoaded", function () {
  const resultado = document.getElementById("resultado");
  if (resultado) {
    setTimeout(() => {
      resultado.classList.add("show");
    }, 100);
  }
});
</script>

</body>
</html>