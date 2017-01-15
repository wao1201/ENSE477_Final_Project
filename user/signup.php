   <?php include('../header.php'); ?>
  <script src='../js/signup.js'></script>
  <link href="../css/form.css" rel="stylesheet" type="text/css" />
   
   <div>
   <fieldset>
   <legend>Sign Up</legend>
   <form id="SignupForm" name="SignupForm" method="post">
   <br/>
   <p>
   <label for="username" class="label">Username:</label>
   <input id="username" name="username" type="text" class="input" />
   <span style="color:red">(Required: 3-15 characters)</span>
   <p/>
   <br/>
   <p>
   <label for="password" class="label">Password:</label>
   <input id="password" name="password" type="password" class="input" />
   <span style="color:red">(Required: more than 6 characters)</span>
   <p/>
   <br/>
   <p>
   <label for="repass" class="label">Re-enter Password:</label>
   <input id="repass" name="repass" type="password" class="input" />
   <p/>
   <br/>
   <p>
   <label for="email" class="label">Email:</label>
   <input id="email" name="email" type="text" class="input" />
   <span style="color:red">(Required)</span>
   <p/>
   <br/>
   <p>
   <input type="submit" name="submit" value="submit" class="lleft" />
   </p>
   <br/>
   </form>
   </fieldset>
   </div>

<!-- -->  
<?php include ('../footer.php'); ?>