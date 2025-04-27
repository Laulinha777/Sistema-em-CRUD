<?php 
require_once("includes/conectarBDMysqli.php");

// Verifica se veio um ID pela URL e busca os dados do paciente
$paciente = [
    'paciID' => '',
    'paciNome' => '',
    'paciCPF' => '',
    'paciDataNascimento' => '',
    'paciEmail' => ''
];

if (isset($_GET['paciID'])) {
    $id = $_GET['paciID'];
    $sql = "SELECT * FROM pacientes WHERE paciID=?";
    if ($stmt = mysqli_prepare($conexao, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $paciente = mysqli_fetch_assoc($result);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleAlterar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <title>Alterar</title>
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
            <div class="image-alterar">
                <img src="imagens/medic.svg" alt="">
            </div>

            <form class="form-alterar" method="POST">
                <h1>Alterar Dados</h1>
                <input type="hidden" name="paciID" value="<?php echo $paciente['paciID']; ?>">
                <input type="text" name="paciNome" id="paciNome" placeholder="Nome" value="<?php echo $paciente['paciNome']; ?>" required>
                <input type="number" name="paciCPF" id="paciCPF" placeholder="CPF" value="<?php echo $paciente['paciCPF']; ?>" required>
                <input type="date" name="paciDataNascimento" id="paciDataNascimento" placeholder="Data de Nascimento" value="<?php echo $paciente['paciDataNascimento']; ?>" required>
                <input type="email" name="paciEmail" id="paciEmail" placeholder="E-mail" value="<?php echo $paciente['paciEmail']; ?>" required>
                <input type="submit" name="enviar" value="Alterar Paciente">
            </form>   
        </div>
    </div>

    <?php 
    if (isset($_POST["enviar"])) {
        $paciID = $_POST["paciID"];
        $paciNome = $_POST["paciNome"];
        $paciCPF = $_POST["paciCPF"];
        $paciDataNascimento = $_POST["paciDataNascimento"];
        $paciEmail = $_POST["paciEmail"];

        $sql = "UPDATE pacientes SET paciNome=?, paciEmail=?, paciCPF=?, paciDataNascimento=? WHERE paciID=?";
        if ($stmt = mysqli_prepare($conexao, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssssi", $paciNome, $paciEmail, $paciCPF, $paciDataNascimento, $paciID);
            if (mysqli_stmt_execute($stmt)) {
                echo "<p>Dados do cliente $paciNome alterados com sucesso! Verifique abaixo as alterações realizadas.</p>";

                // Recupera os dados atualizados
                $sql_select = "SELECT * FROM pacientes WHERE paciID=?";
                if ($stmt_select = mysqli_prepare($conexao, $sql_select)) {
                    mysqli_stmt_bind_param($stmt_select, "i", $paciID);     
                    mysqli_stmt_execute($stmt_select);
                    $result = mysqli_stmt_get_result($stmt_select);
                    $cliente = mysqli_fetch_assoc($result);

                    echo '<div class="dados">
                            <h2>Dados Alterados</h2>
                            <p><strong>Código:</strong> <span>'.$cliente['paciID'].'</span></p>
                            <p><strong>Nome:</strong> <span>'.$cliente['paciNome'].'</span></p>
                            <p><strong>CPF:</strong> <span>'.$cliente['paciCPF'].'</span></p>
                            <p><strong>Email:</strong> <span>'.$cliente['paciEmail'].'</span></p>
                            <p><strong>Data de Nascimento:</strong> <span>'.$cliente['paciDataNascimento'].'</span></p>
                        </div>';
                    mysqli_stmt_close($stmt_select);
                }
            } else {
                echo "<p align='center'>Erro ao executar atualização.</p>";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "<p align='center'>Erro ao preparar a consulta SQL. Tente novamente mais tarde.</p>";
        }
        mysqli_close($conexao);
    }
    ?>
</body>
</html>
