
<input type="text" id="message"/>

<input type="button" class="sendButton" value="submit"></input>

<script type="text/javascript">
$(document).ready(function(){
    $('.sendButton').attr('disabled',true);
    
    $('#message').keyup(function(){
        if($(this).val().length !=0){
            $('.sendButton').attr('disabled', false);
        }
        else
        {
            $('.sendButton').attr('disabled', true);        
        }
    })
});
</script>