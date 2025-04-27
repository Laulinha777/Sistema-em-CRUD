<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleCadastra.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Cadastro</title>
</head>
<body>
    <header>
        <nav class="menuu">
            <li><a href="cadastro.php">Cadastro</a></li>
            <li><a href="pesquisar.php">Pesquisar</a></li>
            <li><a href="alterar.php">Alterar</a></li>
            <li><a href="excluir.php">Excluir  </a></li>
        </nav>
        <div class="butons">
            <button onclick="">Dúvidas?</button>
            
        </div>
    </header>

    <div class="flex">
        <div class="container">
            <div class="image-cadastro">
                <img src="imagens/medic.svg" alt="Imagem de Médicos">
            </div>
            <form method="POST" action="cadastro.php">
                <h1>Cadastrar Paciente</h1>
                <input type="text" name="paciNome" id="paciNome" placeholder="Nome">
                <input type="number" name="paciCPF" id="paciCPF" placeholder="CPF">
                <input type="email" name="paciEmail" id="paciEmail" placeholder="E-mail">
                <input type="date" name="paciDataNascimento" id="paciDataNascimento" placeholder="Data de Nascimento">
                <input type="submit" value="Cadastrar Paciente">
            </form>
        </div>
    </div>
        <br><a href='index.php'>Voltar para a página de início</a><br/>
    <?php 

    require_once("includes/conectarBDMysqli.php");

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $paciNome = trim($_POST["paciNome"]); /*trim serve para remover espaços em branco*/
        $paciCPF = trim($_POST["paciCPF"]);
        $paciEmail = trim($_POST["paciEmail"]);
        $paciDataNascimento = new DateTime(trim($_POST["paciDataNascimento"]));
        $dataFormatada = $paciDataNascimento -> format('d/m/Y');

            /*Verifica se todos os campos forão preenchidos*/
        if (empty($paciNome) || empty($paciCPF) || empty($paciEmail) || empty($paciDataNascimento)){
            die ("<div align='center'>Todos os campos são obrigatórios!! <a href='cadastro.php'>Voltar</a></div>");
        }

    $sql= "INSERT INTO pacientes(paciNome, paciCPF, paciEmail, paciDataNascimento)
            VALUES (?, ?, ?, str_to_date(?, '%d/%m/%Y'))";

    $stmt = mysqli_prepare($conexao, $sql); /*$stmt = o comando SQL já preparado e pronto pra receber os valores de forma segura.*/

    if(!$stmt){
        die("Erroao preparar query: ".mysqli_error($conexao
    ));
    }


    mysqli_stmt_bind_param($stmt, 'ssss', $paciNome, $paciCPF, $paciEmail, $dataFormatada);
    
    if (mysqli_stmt_execute($stmt)){
        echo "<div align='center'>Cliente cadastrado com sucesso! <a href='cadastro.php'>Cadastrar outro</a></div>";
    }
    else{
        echo "<div align='center'>Erro ao cadastrar cliente: " . mysqli_error($conexao) . "<br/><a href='cadastro.php'>Voltar</a></div>";
    }
}
    ?>

</body>
</html>