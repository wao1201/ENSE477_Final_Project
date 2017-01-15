<?php 
    include ('../header.php'); 
    include ('../secure_page.php');
?>
<link href="../css/form.css" rel="stylesheet" type="text/css" />
<script src='../js/yard.js'></script>

<!-- Below is the website main files -->	


<p class="p1">

    <fieldset>
    <legend>User Info</legend>
    <form id="UserModForm" name="UserModForm" method="post">
    <br />
    
    <p>
    <label for="password" class="label">New Password:</label>
    <input id="password" name="password" type="password" class="input" />
    <span style="color:red">(Required: more than 6 characters)</span>
    </p>
    <br />

    <p>
    <label for="repass" class="label">Re-enter New Password:</label>
    <input id="repass" name="repass" type="password" class="input" />
    </p>
    <br />

    <p>
    <label for="email" class="label">Email:</label>
    <input id="email" name="email" type="text" class="input" />
    <span style="color:red">(Required)</span>
    </p>
    <br />

    <p>
    <label for="notification" class="label">Receive email notifications:</label>
    <input type="checkbox" name="notification" id="notification" class="input" />
    </p>
    <br />

    <p>
    <label for="reputation" class="label">User Reputation:</label>
    <div><p name="reputation" id="reputation"></p></div>
    </p>
    <br />
    <br />

    <p>
    <label for="userType" class="label">User Type:</label>
    <div><p name="userType" id="userType"></p></div>
    </p>
    <br />
    <br />
    <p>
    <input type="submit" name="submit" value="Update" class="lleft" />
    </p>
    <br />

    </form>
      <br />
      <a href=" ../data/table.php?user=true">View my sightings</a>

    </fieldset>

</p>



</div>
</div>

<!-- Above is the website main files -->

<?php include ('../footer.php'); ?>