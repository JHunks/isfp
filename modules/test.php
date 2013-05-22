<script src="includes/showHide.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function(){
	   $('.show_hide').showHide({			 
			speed: 500,  // speed you want the toggle to happen	
			changeText: 1, // if you dont want the button text to change, set this to 0
			showText: 'Login / Register',// the button text to show when a div is closed
			hideText: 'Login / Register' // the button text to show when a div is open				 
		}); 
	});
</script>
<style type="text/css">
#slidingDiv{
    background-color: rgba(0,0,0,0.5);
    -webkit-border-radius: 10px 10px 10px 10px;
    -moz-border-radius: 10px 10px 10px 10px;
    border-radius: 10px 10px 10px 10px; 
    display: none;
    text-align: center;
    border-left: 1px solid #9d9b9c;
    border-right: 1px solid #9d9b9c;
    border-bottom: 1px solid #9d9b9c;
}
</style>
<div class="show_hide" rel="#slidingDiv">
	<a href="#">Show</a>
</div>
<div id="slidingDiv">
	content here
</div>