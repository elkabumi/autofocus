<script type="text/javascript" charset="utf-8"> 
/*
$(document).ready(function() {
//Check if url hash value exists (for bookmark)  
    $.history.init(pageload);     
          
    //highlight the selected link  
    $('a[href=' + document.location.hash + ']').addClass('selected');  
      
    //Seearch for link with REL set to ajax  
    $('a[rel=ajax]').click(function () {  
          
        //grab the full url  
        var hash = this.href;  
          
        //remove the # value  
        hash = hash.replace(/^.*#/, '');  
          
        //for back button  
        $.history.load(hash);     
          
        //clear the selected class and add the class class to the selected link  
        $('a[rel=ajax]').removeClass('selected');  
        $(this).addClass('selected');  
          
        //hide the content and show the progress bar  
        $('#page-content').hide();  
        $('#loading').show();  
          
        //run the ajax  
        getPage();  
      
        //cancel the anchor tag behaviour  
        return false;  
    });  
});
function pageload(hash) {  
    //if hash value exists, run the ajax  
    if (hash) getPage();      
}  
          
function getPage() {  
      
    //generate the parameter for the php script  
    //var data = 'page=' + document.location.hash.replace(/^.*#/, '');  
    var data = document.location.hash.replace(/^.*#/, '');  
    $.ajax({  
        url: "<?=site_url('"+data+"')?>",    
        type: "GET",          
        data: data,       
        cache: false,  
        success: function (html) {    
            $('#loading').hide();
            $('#page-content').html(html);  
            $('#page-content').fadeIn('slow');         
        }         
    });  
}  
*/
</script> 
<ul>  
    <li><a href="#home" rel="ajax">Home</a></li>   
    <li><a href="#test" rel="ajax">Portfolio</a></li>   
    <li><a href="#page3" rel="ajax">About</a></li>  
    <li><a href="#page4" rel="ajax">Contact</a></li>
</ul> 
