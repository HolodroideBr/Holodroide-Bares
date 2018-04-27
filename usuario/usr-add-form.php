<?php

 require_once 'include/init.php';
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>

      <title>Holodroide - USUÁRIO</title>        

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

     <div class="container" style="margin-bottom:200px;">

            <div class="row">
                <div class="col-md-12" style="text-align:center;margin:50px 0 50px 0;color:#ff0000;">
                    <img src="https://holodroide.com/images/logo_holodroide_sistema.png" width="300px" height="34px"><br />
                </div>
            </div>  

      <div class="row">
          <div class="col-md-12" style="text-align:center;margin:0 0 20px 0;">
            Preencha o formulário abaixo e <br>clique em CADASTRAR.
          </div>
      </div> 

      <form action="add-user.php" method="post"  name="form-user" id="form-cli">
      <div class="row">

          <div class="col-md-12" style="text-align:center;padding:5px;margin:0 0 5px 0;">
            NOME<br>        
            <input name="nome_usr" type="text" id="nome_usr" size="65" value="" style="width:100%;max-width:270px;font-size:0.800em;">
          </div> 

          <div class="col-md-12" style="text-align:center;padding:5px;margin:0 0 5px 0;">
            EMAIL    <br>    
            <input name="email_usr" type="text" id="email_usr" size="65" value="" style="width:100%;max-width:270px;font-size:0.800em;">
          </div>  

          <div class="col-md-12" style="text-align:center;padding:5px;margin:0 0 5px 0;">  
             SENHA  <br>
            <input name="senha_usr" type="text" id="senha_usr" size="65" value="" style="width:100%;max-width:270px;font-size:0.800em;">
          </div>   

          <div class="col-md-12" style="text-align:center;padding:5px;margin:0 0 10px 0;">    
            <select name="cliente" style="width:100%;max-width:270px;">
              <option value="">SELECIONE O CLIENTE</option>
              
              <?php

              $PDO = db_connect();

              // SQL para selecionar os registros
              $sql = "SELECT * FROM tbl_cli ORDER BY nome_cli ASC";
               
               
              // seleciona os registros
              $stmt = $PDO->prepare($sql);
              $stmt->execute();
              while ($user = $stmt->fetch(PDO::FETCH_ASSOC)):  

              echo '<option value="'. $user['id_cli'].'">'.$user['empresa_cli'].'</option>';

              endwhile;
              ?>
            </select>
          </div>   

      </div> 

      <div class="row">
          <div class="col-md-12" style="text-align:center;padding:5px;">        
            <input type="submit" name="button" id="button"  class="btn btn-success" value="CADASTRAR" style="width:100%;max-width:270px;font-size:0.800em;" />
          </div>          
      </div>  
      </form>

    </div>

</body>
</html>
