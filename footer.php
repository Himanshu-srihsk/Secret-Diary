   
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"></script>
	  
	  
	   

      <script type="text/javascript">
	  
	  function myFunction() {
    var x = document.getElementById("myInput");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

        $(".toggleform").click(function() {
            
            $("#signupform").toggle();
            $("#loginform").toggle();
            
            
        });
		$('#diary').bind('input propertychange', function() {

     
$.ajax({
  method: "POST",
  url: "updatedatabase.php",
  data: {content:$("#diary").val()}
 
});
});

</script> 

 </body>
</html>
