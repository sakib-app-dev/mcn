$(document).ready(function(){
    $('#search').keyup(function(){
        var query=$(this).val();
        if(query !==""){
            $.ajax({
                url:"search.php",
                method:"POST",
                data:{query: query},
                success:function(data){
                    $('#searchResult').fadeIn();
                    $('#searchResult').html(data);
                }
            });
        }else{
            $('#searchResult').fadeOut();
            $('#searchResult').html("");
        }
        
        $(document).on('click','li',function(){
            $("#searchResult").val($(this).text());
            $("#searchResult").fadeout();
        });
    });
});