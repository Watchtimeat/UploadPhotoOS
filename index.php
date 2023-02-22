<?php  

//Armazena o numero da OS
if (isset($_POST['numeroOS'])) {
  // Recupera dado do formulário
  $numeroOS = $_POST['numeroOS'];
  $caracteres = strlen($numeroOS);
  //Verificação da quantidade de caracteres para a formatação do nome do arquivo
  if ($caracteres == 6) {
    $nomeDaFoto = "F-".$numeroOS."-";
  }elseif ($caracteres == 5) {
    $nomeDaFoto = "F-0".$numeroOS."-";
  }elseif ($caracteres == 4) {
    $nomeDaFoto = "F-00".$numeroOS."-";
  }elseif ($caracteres == 3) {
    $nomeDaFoto = "F-000".$numeroOS."-";
  }elseif ($caracteres == 2) {
    $nomeDaFoto = "F-0000".$numeroOS."-";
  }elseif ($caracteres == 1) {
    $nomeDaFoto = "F-00000".$numeroOS."-";
  }
}

$alfabeto = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

$extensoesPermitidas = ['jpg'];

$contador = 0;

// Definir o caminho da pasta para armazenar as imagens
$upload_folder = 'D:/CDSIS/Estoklus/Fotos/';

if (isset($_POST['upload'])) {
  // Recuperar os dados do formulário
  $files = $_FILES['images'];

  //Conta quantos arquivos estão sendo enviados
  $count = count($_FILES['images']['tmp_name']);
  $ultimoCaractere = $alfabeto[0];

  // Loop para percorrer cada arquivo enviado
  foreach ($files['name'] as $index => $file_name) {
    $contador = $contador+1;
    //Verifica se existe uma foto com o nome da Os
    $word = $nomeDaFoto;
    $directory = $upload_folder;
    $arquivos = glob("$directory*.jpg");
    foreach ($arquivos as $file) {
      if (strpos($file, $word) !== false) {
        //Se houver fotos com o nome da os, adicionar com a proxima letra do alfabeto
        $ultimoCaractere = substr($file, -5, 1);
        $result = array_search($ultimoCaractere, $alfabeto);
        $ultimoCaractere = $alfabeto[$result+1];
      }
    }

    //Pega a extensão do arquivo
    $extensao = substr($file_name, -3);

    //Verifica se a extensão é permitida
    if (!in_array($extensao, $extensoesPermitidas)) {
      die('Apenas imagens no formato JPG são aceitas.');
    }

    //Renomear e mover o arquivo para a pasta
    move_uploaded_file($files['tmp_name'][$index], "$upload_folder$nomeDaFoto$ultimoCaractere".".$extensao");
  }
  echo "<div id='texto'><h3>$contador Fotos enviadas com sucesso!</h3></div>";
}


?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <style type="text/css">
    body{
      padding-top: 10%;
      background-color: #333333;
      color: #f5f5f5;
    }

    input{
      padding: 16px;
    }

    .form-container {
      display: flex;
      justify-content: center;
      text-align: center;
    }

    .form-container form {
      width: '25%';
    }

    .logo{
      text-align: center;
    }

    #envia{
      width: 335px;
    }

    #texto{
      text-align: center;
      color: #52ff71;
    }
  </style>
</head>
<body>
  <div class="logo">
    <img src="logo/branca.png">
  </div>
  <div class="form-container">
    <form action="" method="post" enctype="multipart/form-data">
      <label>Número da O.S: <input type="text" name="numeroOS" required maxlength="6"></label><br>
      <input type="file" name="images[]" multiple><br>
      <input type="submit" name="upload" value="Enviar" id="envia">
    </form>
  </div>
</body>
</html>
