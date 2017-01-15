<?php include ('header.php'); ?>

<!-- Below is the website main files -->

<style>
table,th,td
{
border:1px solid black;
border-collapse:collapse;
}
th,td
{
padding:5px;
}
</style>	

<p class="p1">
<p>
<h3>Structure Brief</h3>

<table>

<tr>
<th>Page</th>
<th>Description</th>
</tr>

<tr>
<td>Submit Sightings</td>
<td>
This page is used for submitting sigle sighting, which could include: (1) a photo of what you saw; (2) the animal name; 
(3) the time and date of the sighting; (4) the location of where you got the sighting; (5) the animal's gender, age, and status; 
(6) a short description to tell our community more about this sighting. 
</td>
</tr>

<tr>
<td>Explore Sightings</td>
<td>
This page is used for viewing and downloading our data by applying a filter you want. Our system provide three ways 
for users: table, graphs, and heat map.
</td>
</tr>

<tr>
<td>Sighting Detail</td>
<td>This page is used for displaying the detail of a single sighting. Users can see all relative information about one specific 
sighting and rate it based on the quality of the data.
</td>
</tr>

<tr>
<td>Update Sighting Detail</td>
<td>
This page is used for editing all information of a single sighting by a power user or the creator of this sighting.
</td>
</tr>

<tr>
<td>CSV Upload</td>
<td>This page is used for inputing bulk data to our system. The specification of CSV file format is listed below.</td>
</tr>

<tr>
<td>My Account</td>
<td>This page is used for modifying account information, such as email address, and password.</td>
</tr>

<tr>
<td>Help</td>
<td>This page is used for briefly describing the role of each major page.</td>
</tr>

<tr>
<td>About</td>
<td>This page contains brief description of our system and acknowledgement.</td>
</tr>

</table>
</p>
<br>

<p>
<h3>CSV Format Specification</h3>
In order to ensure our system could process your data file properly and successfully. Please submit your CSV file in following 
format:

<table>
<tr>
<td>animal name</td>
<td>sighting time</td>
<td>sighting date</td>
<td>latitude of sighting location</td>
<td>longitude of sighting location</td>
<td>animal gender</td>
<td>animal status</td>
<td>description</td>
<td>animal age</td>
</tr>
</table>


</p>

<br>
<p>
<h3>Need further help?</h3> 
Email us <a href="mailto:animalense@gmail.com?Subject=General%20Inquiry" target="_top">
NOW</a>
</p>

</p>



</div>
</div>

<!-- Above is the website main files -->

<?php include ('../footer.php'); ?>