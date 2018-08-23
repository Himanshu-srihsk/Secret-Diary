<?php
mysql_connect("localhost","root","master1234");
mysql_select_db("reg");
$query=mysql_query("select * from project order by id desc");
$rowcount=mysql_num_rows($query);
if(isset($_REQUEST["submit"]))
{
$chk=$_REQUEST["chk"];
$a=implode(",",$chk);
mysql_query("delete from project where id in($a)");

}
?>
<form>
<table border="1" align="center" style=" background-color:green;font-color=red">
<tr>
<td>Id</td>
<td>Username</td>
<td>password</td>

<td>Diary</td>
<td>Edit</td>
<td><input type="submit" name="submit" value="submit"></td>
</tr>
<?php
for($i=1;$i<=$rowcount;$i++)
{
$row=mysql_fetch_array($query);

?>
<tr>
<td><?php echo $row["id"] ?></td>
<td><?php echo $row["email"] ?></td>
<td><?php echo $row["password"] ?></td>
<td><?php echo $row["diary"] ?></td>
<td><input type="checkbox" name="chk[]" value="<?php echo $row["id"] ?>"></td>

</tr
<?php
}
?>
</table>
</form>
