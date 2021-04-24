
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/markerStyle.css" />


<style>
    article, aside, figure, footer, header, hgroup, 
    menu, nav, section { display: block; }
</style>

<!-- show image after upload -->
<script>
    var count = 0;

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                //  $('#image').css('background', 'transparent url('+e.target.result +') left top no-repeat') .width('Auto').height(500);

                $('#imge')
                .attr('src', e.target.result);
                //.max-height(400);

                $('#imge').css('max-width', "600px");
                $('#imge').css('max-height', "400px");
            };

            reader.readAsDataURL(input.files[0]);
            count++;
        }

    }
</script>

<!-- END  -->

<!-- get coordinates of the clicked positions  -->

<script type="text/javascript">


    var Point = 1;
    var X1, Y1, X2, Y2, X3, Y3, X4, Y4;
    var a = "";
    var PosX = 0;
    var PosY = 0;

    function FindPosition(oElement)
    {
        if (typeof (oElement.offsetParent) != "undefined")
        {
            for (var posX = 0, posY = 0; oElement; oElement = oElement.offsetParent)
            {
                posX += oElement.offsetLeft;
                posY += oElement.offsetTop;
            }
            return [posX, posY];
        }
        else
        {
            return [oElement.x, oElement.y];
        }
    }

    function GetCoordinates(e)
    {

        var ImgPos;
        ImgPos = FindPosition(myImg);
        if (!e)
            var e = window.event;
        if (e.pageX || e.pageY)
        {
            PosX = e.pageX;
            PosY = e.pageY;
        }
        else if (e.clientX || e.clientY)
        {
            PosX = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
            PosY = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
        }
        PosX = PosX - ImgPos[0];
        PosY = PosY - ImgPos[1];

        if ($("#upload").val() != "") {            
            $('<input>').attr({
                type: 'hidden',
                id: Point,              
                value:PosX + "," + PosY
            }).appendTo('form');
            
            Point++;
            //                        a = a + PosX + "," + PosY + "-"; 
            //                        document.getElementById("vall").value = a;
        }

    }

</script>

<script type="text/javascript">

    var myImg = document.getElementById("image");
    myImg.ondblclick = GetCoordinates;
   
</script>
<!-- END -->

<!-- marker function -->

<script type="text/javascript">
    var elementId = "";   
    var count = 0;
    
    function getLinkId(element) {        
        elementId = element.id;


        var link_x = document.getElementById(elementId);        
        link_x.parentNode.removeChild(link_x);

        var corssCount = elementId.substr(4);       //starts with 0 
        $('#'+corssCount).remove();       
    
    }

    $(document).ready(function() {       
        
        var nextAreaCount = 0;
        
        $("#multiPosition").click(function(){           
            if(nextAreaCount<9){
                nextAreaCount++;
            }else{
                nextAreaCount=0;
            }            
        });
        
        $('#image').dblclick(function(e) {

            if ($("#upload").val() != '') {
                e.preventDefault();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;

                $('<img />').attr({
                    //src: '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossred.png',
                    src: imageChange(nextAreaCount),
                    id: 'img' + count                     
                }).css('top', (y-7)).css('left', (x-6)).css('width', 12).css('height', 14).appendTo($('<a />').attr({
                    href: '#',
                    id: 'link' + count,
                    onClick: "return false;"
                }).appendTo($('#image')));


                $('#img' + count).popover({
                    html: true,
                    title: 'Options',
                    placement: 'bottom',
                    content: '<input type="button" id="link' + count + '" value="Remove" onclick="getLinkId(this)">'
                }).parent().on('click', '#remove-btn', function() {

                });
                $("#multiPosition").prop("disabled", false);
                count++;
            } else {
                alert("Please upload a file");
            }
        });
        //hide popover on lost focus
        $('body').on('click', function (e) {
            for(var i=0; i<10; i++) {
                if('img' + i != e.target.id) {
                    $('#img'+i).popover('hide');
                }
            }
        });
        
    });
    
    function imageChange(areaCount){
        
        if(areaCount%8==0){
            return '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossred.png';
        }else if(areaCount%8==1){
            return '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/cross1.png';
        }else if(areaCount%8==2){
            return '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossblue.png';
        }else if(areaCount%8==3){
            return '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossbrown.png';
        }else if(areaCount%8==4){
            return '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossgreen.png';
        }else if(areaCount%8==5){
            return '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossgrey.png';
        }else if(areaCount%8==6){
            return '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crosspink.png';
        }else if(areaCount%8==7){
            return '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossrorange.png';
        }else if(areaCount%8==0){
            return '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossyellow.png';
        }
        
    }


</script>


<!-- END  -->

<br />

<div id="hotspot-instructions">

    <ul>
        <li><p> Please upload an image. </p></li>
        <li><p> Please mark the correct area using double clicks. </p></li>
        <li><p> If you want to mark multiple areas,  </p></li>
        <ul>
            <li><p> Mark the first area. </p></li>
            <li><p> Then click next area button. </p></li>
            <li><p> After that you can mark the next area. </p></li>
            <li><p> Please follow this to mark any number of multiple areas. </p></li>
        </ul>
        <li><p>You can remove any marked position by clicking on it. </p></li>
    </ul>

</div>

<br />


<input type='file' id="upload" name="uploadedFile" onchange="readURL(this);"/>
<input type="button" id="multiPosition" value="Next Area" class="btn" onclick="markMultiplePosition()" >


<div id="image" style="max-width:600px; max-height:400px;clear: both">
    <img id="imge" />

</div>

<input type="hidden" id="vall" name="vall">


<script type="text/javascript">
    // var multiBtnCount=''
    function markMultiplePosition(){
        // $('#multiPosition').attr('disabled') = 'disabled';
        
        
        $("#multiPosition").prop("disabled", true);
        $('<input>').attr({
            type: 'hidden',
            id: Point,
            //name: 'bar'
            value:'/'
        }).appendTo('form');
            
        Point++;
        count++;
            
    }    
    
    function finish(){      
        var j='';
        for(k=0;k<Point;k++){           
            if ($('#'+k).length) {
                j=j+$('#'+k).val()+',';
            }           
        }       
        document.getElementById("vall").value = j; 
    }
    
    
    var submitbtn = document.getElementById("bttsubmit");
    submitbtn.onclick =finish;
</script>
