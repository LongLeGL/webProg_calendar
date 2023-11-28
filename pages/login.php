<main> 

  <form id='loginForm' action= "/controllers/login_processing.php" method="post">
    <h2>LOGIN</h2>

    <label class='loginLabels'>User Name</label>
    <input type="text" name="uname" placeholder="User Name" required
    value="<?php
      session_start();
      if(isset($_SESSION['user_name'])) { 
        echo $_SESSION['user_name']; 
      } 
    ?>" >
    <br>

    <label class='loginLabels'>Password</label>
    <input  type="password" name="password" placeholder="Password" id='passInput'
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
    <br> 

    <button id='loginSubmit' type="submit">Login</button>
    <?php
      if (isset($_GET['error'])) {
        echo'<div>Login failed: '. $_GET['error'].'</div>';
      }
    ?>

    <div class="passRules">
      <h3>Password must contain the following:</h3>
      <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
      <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
      <p id="number" class="invalid">A <b>number</b></p>
      <p id="length" class="invalid">Minimum <b>8 characters</b></p>
      <i>Test acc: padmin TestAdm1n</i>
    </div>
  </form>
    
  <script src="./scripts/verifyPass.js"></script>
</main>
