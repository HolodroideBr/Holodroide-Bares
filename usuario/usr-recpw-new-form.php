<?php
session_start();

// Inclui conexão com BR MySql
// Confere se usuário  está logado (Administrador, Cliente ou Usuário)
// Faz o Hash de senha 
require_once 'include/init.php';


// pega o ID da URL
$idusr = isset($_GET['idusr']) ? (int) $_GET['idusr'] : null;
 
// valida o ID
if (empty($idusr))
{
    echo '<script type="text/javascript">
    alert("SÉRIO?! MESMO?!\nONDE ESTÁ O ID, MAN?!!! ");
    window.history.back()
        </script>';

        exit;
}
 
// busca os dados do usuário a ser editado
$PDO = db_connect();
$sql = "SELECT nome_usr, senha_usr FROM tbl_usr WHERE id_usr = :idusr";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':idusr', $idusr, PDO::PARAM_INT);
 
$stmt->execute();
 
$user = $stmt->fetch(PDO::FETCH_ASSOC);
 
// se o método fetch() não retornar um array, significa que o ID não corresponde a um usuário válido
if (!is_array($user))
{
    echo "Nenhum usuário encontrado";
    exit;
}
?>

<!doctype html>
<html>
    <head>

        <title>HOLODROIDE USUÁRIO</title>        

        <meta charset="utf-8">

        <!-- ===================== Mobile Specific ============================= -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
 
        <!-- ==================== BootStrap ====================== -->   
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>        
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

     </head>
 
    <body>
         <div class="container">


            <div class="row">
                <div class="col-md-12" style="text-align:center;margin:50px 0 0 0;color:#ff0000;">
                    <img src="https://www.holodroide.com/images/logo_holodroide_sistema.png?1222259157.415" width="200px" height="23px"><br />
                    <p><h6>RECUPERAR SENHA</h6></p> 
                </div>
            </div> 

             
            <div class="row">
                <div class="col-md-12" style="text-align:center;;margin:0 0 10px 0;">
                Olá <?php echo $user['nome_usr'] ?>, <br><br>
                INFORME A NOVA SENHA E CLIQUE<br>
                NO BOTÃO "CONFIRMAR"                   
                </div>
            </div>

             <div class="row">
                <div class="col-md-12" style="text-align:center;margin:0 0 30px 0;">
                    <form action="usr-recpw-new.php" method="post" name="form1" id="form1">
                        NOVA SENHA   
                        <br>
                        <input name="senha_usr" type="text" id="senha_usr" size="50" value="" style="width:250px; background-color: #fff;">
             
                        <br><br>
             
                    <input type="hidden" name="idusr" value="<?php echo $idusr ?>">   
                    <input type="submit" name="button" id="button"  class="btn" style="background-color: #ddd;margin:2px;" value="CONFIRMAR" />
                  </form>
                </div>
            </div>


          <div class="row">

              <div class="col-md-12" style="text-align:center;margin:0 0 10px 0;">            
                  Ainda não está cadastrado?<br>Cadastre-se agora!
              </div>  

              <div class="col-md-12" style="text-align:center;margin:0 0 30px 0;">            
                  <a href="usr-add-form.php" class="btn btn-danger" style="width:100%;max-width:250px;font-size:0.800em;">CADASTRAR</a>
              </div>                
          </div> 

                   
        </div>
 
    </body>
</html>