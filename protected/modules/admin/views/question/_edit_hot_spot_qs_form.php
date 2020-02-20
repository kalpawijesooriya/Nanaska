<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/markerStyle.css" />


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





<script type="text/javascript">
    function showImage() {
        // myImage : ID of image on which to place new image

        var xCoordinates = new Array();
        var yCoordinates = new Array();

<?php
$image_coordinates = Hotspot::model()->getImageName($model->question_id);
$coords = '';
$pieces = '';
$tok = Array();

$coordX = Array();
$coordY = Array();

foreach ($image_coordinates as $coordinate) {
    $coords = $coordinate->coordinates;
}

$pieces = explode("/", $coords);

$temp1 = array();
for ($k = 0; $k < sizeof($pieces); $k++) {
    $tempp = array();

    $tok[$k] = explode(",", $pieces[$k]);
    foreach ($tok[$k] as $key => $value) {
        //print_r("<<".$key."-".$value.">>");
        if ($value != '') {
            $tempp[] = $value;
        }
    }
    $temp1[] = $tempp;
}
$numberofareas = 0;

foreach ($temp1 as $tm) {
    if ($numberofareas > 0) {
        $coordX[] = "-";
        $coordY[] = "-";
    }
    foreach ($tm as $key => $value) {
        if ($key % 2 == 0) {
            $coordX[] = $value;
        } else {
            $coordY[] = $value;
        }
    }
    $numberofareas++;
}

for ($i = 0; $i < sizeof($coordX); $i++) {
    ?>
            xCoordinates.push('<?php echo $coordX[$i]; ?>');
            yCoordinates.push('<?php echo $coordY[$i]; ?>');
    <?php
}
?>
        //alert(yCoordinates);
        var image = document.getElementById('myImage');
        var crossColorCount = 0;
        margin = 0;

        // Location inside the image

        for (ik = 0; ik < xCoordinates.length; ik++) {

            l = image.offsetLeft;
            t = image.offsetTop;
            w = image.width;
            h = image.height;

            if (xCoordinates[ik] == "-" && yCoordinates[ik] == "-") {
                crossColorCount++;
            }

            if (xCoordinates[ik] != "-") {
                offX = parseInt(xCoordinates[ik]);
            }
            if (yCoordinates[ik] != "-") {
                offY = parseInt(yCoordinates[ik]);
            }

            if (offX > margin)
                offX -= margin;
            if (offY > margin)
                offY -= margin;

            l += offX;
            t += offY;

            if (xCoordinates[ik] != "-") {
                var newImage = document.createElement("img");
                if (crossColorCount == 0) {
                    newImage.setAttribute('src', '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossred.png');
                } else if (crossColorCount == 1) {
                    newImage.setAttribute('src', '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/cross1.png');
                } else if (crossColorCount == 2) {
                    newImage.setAttribute('src', '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossblue.png');
                } else if (crossColorCount == 3) {
                    newImage.setAttribute('src', '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossbrown.png');
                } else if (crossColorCount == 4) {
                    newImage.setAttribute('src', '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossgreen.png');
                } else if (crossColorCount == 5) {
                    newImage.setAttribute('src', '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossgrey.png');
                } else if (crossColorCount == 6) {
                    newImage.setAttribute('src', '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crosspink.png');
                } else if (crossColorCount == 7) {
                    newImage.setAttribute('src', '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossrorange.png');
                } else if (crossColorCount == 8) {
                    newImage.setAttribute('src', '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossyellow.png');
                }

                newImage.style.width = '12px';
                newImage.style.height = '14px';
                newImage.setAttribute('class', 'overlays');
                newImage.style.left = l - 7 + "px";
                newImage.style.top = t - 6 + "px";

                $('#imge').append(newImage);
            }

        }

    }
</script>

<?php
$uploaded_images = Hotspot::model()->getImageName($question_id);


foreach ($uploaded_images as $images) {
    if ($images->image_name != Null) {

        echo '<style>
                .overlays{
                 position: absolute;
                } 
                </style>';

        echo '<p><b>Image with selected points</b></p>';

        echo '<div id="imge" style="max-width:600px; max-height:400px">';
        echo '<img id="myImage" src = "' . Yii::app()->request->baseUrl . '/images/hotspot_answer_images/' . $images->hotspot_id . '/' . $images->image_name . '" style="max-width:600px; max-height:400px" />';
        echo '</div>';
    }
    ?>                                            
    <?php
}
?>


<?php
$uploaded_images = Hotspot::model()->getImageName($question_id);

if ($uploaded_images != NULL) {

    foreach ($uploaded_images as $images) {

        if ($images->image_name != Null) {

            echo '<style>
                    .overlays{
                     position: absolute;
                    } 
             </style>';

            echo '<br /><br />';
            echo '<p><b>Update Image</b></p>';

            echo '<div id="sameImge" style="max-width:600px; max-height:400px">';
            echo '<img id="myImage2" src = "' . Yii::app()->request->baseUrl . '/images/hotspot_answer_images/' . $images->hotspot_id . '/' . $images->image_name . '" style="max-width:600px; max-height:400px" />';
            echo '</div>';
        }
    }
} else {
    echo '<div id="sameImge" style="max-width:400px; max-height:400px">';
    echo '<img id="myImage2" src = "' . Yii::app()->request->baseUrl . '/images/hotspot_answer_images/noImage/no_image.png " style="max-width:600px; max-height:400px" />';
    echo '</div>';
}
?>   

<style>
    article, aside, figure, footer, header, hgroup, 
    menu, nav, section { display: block; }
</style>


<!-- show image after upload -->
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                //  $('#image').css('background', 'transparent url('+e.target.result +') left top no-repeat') .width('Auto').height(500);

                $('#myImage2')
                        .attr('src', e.target.result);
                        //.height(400);

                $('#myImage2').css('max-width', '600px');
                $('#myImage2').css('max-height', '400px');
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

</script>

<!-- END  -->


<!-- get coordinates of the clicked positions  -->

<script type="text/javascript">


    var Point = 1;
    var X1, Y1, X2, Y2, X3, Y3, X4, Y4;
    var a = "";

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
        //  alert("get coords");
        var PosX = 0;
        var PosY = 0;
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

        $('<input>').attr({
            type: 'hidden',
            id: Point,
            //name: 'bar'
            value: PosX + "," + PosY
        }).appendTo('form');

        Point++;
        //                        a = a + PosX + "," + PosY + "-"; 
        //                        document.getElementById("vall").value = a;


    }

</script>

<script type="text/javascript">

    var myImg = document.getElementById("sameImge");
    myImg.ondblclick = GetCoordinates;

</script>
<!-- END -->

<script type="text/javascript">

    var elementId = "";
    hidden_elements = 0;

    function getLinkId(element) {
        elementId = element.id;
        var link_x = document.getElementById(elementId);
        link_x.parentNode.removeChild(link_x);

        var corssCount = elementId.substr(4);       //starts with 0 
        var actualCount = parseInt(corssCount);
        var deleteCount = actualCount + 1;
        $('#' + deleteCount).remove();
    }

    $(document).ready(function () {
        var count = 0;
        var nextAreaCount = 0;

        $("#multiPosition").click(function () {
            if (nextAreaCount < 9) {
                nextAreaCount++;
            } else {
                nextAreaCount = 0;
            }
        });

        $('#sameImge').dblclick(function (e) {
            var someimage = document.getElementById('sameImge');
            var myimg = someimage.getElementsByTagName('img')[0];
            var mysrc = myimg.src;

            if (mysrc != "<?php echo Yii::app()->request->baseUrl . '/images/hotspot_answer_images/noImage/no_image.png' ?>") {

                e.preventDefault();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;

                $('<img />').attr({
                    src: imageChange(nextAreaCount),
                    id: 'img' + count
                }).css('top', (y-7)).css('left', (x-6)).css('width', 12).css('height', 14).appendTo($('<a />').attr({
                    href: '#',
                    id: 'link' + count,
                    onClick: "return false;"
                }).appendTo($('#sameImge')));

                $('#img' + count).popover({
                    html: true,
                    title: 'Options',
                    placement: 'bottom',
                    content: '<input type="button" id="link' + count + '" value="Remove" onclick="getLinkId(this)">'
                }).parent().on('click', '#remove-btn', function () {

                });
                $("#multiPosition").prop("disabled", false);
                count++;


            } else {
                alert("Please upload an image");
            }
        })

        $('body').on('click', function (e) {
            for (var i = 0; i < 10; i++) {
                if ('img' + i != e.target.id) {
                    $('#img' + i).popover('hide');
                }
            }
        });


        function imageChange(areaCount) {

            if (areaCount % 8 == 0) {
                return '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossred.png';
            } else if (areaCount % 8 == 1) {
                return '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/cross1.png';
            } else if (areaCount % 8 == 2) {
                return '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossblue.png';
            } else if (areaCount % 8 == 3) {
                return '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossbrown.png';
            } else if (areaCount % 8 == 4) {
                return '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossgreen.png';
            } else if (areaCount % 8 == 5) {
                return '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossgrey.png';
            } else if (areaCount % 8 == 6) {
                return '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crosspink.png';
            } else if (areaCount % 8 == 7) {
                return '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossrorange.png';
            } else if (areaCount % 8 == 0) {
                return '<?php echo Yii::app()->theme->baseUrl; ?>/markerImage/crossyellow.png';
            }

        }



    });

</script>

<!-- END  -->



<script type="text/javascript">
    var multiBtnCount = 0;
    function markMultiplePosition() {

        $("#multiPosition").prop("disabled", true);
        $('<input>').attr({
            type: 'hidden',
            id: Point,
            //name: 'bar'
            value: '/'
        }).appendTo('form');
        multiBtnCount++;
        Point++;
    }

    function finish() {

        var j = '';
        for (k = 0; k < Point; k++) {
            if ($('#' + k).length) {
                j = j + $('#' + k).val() + ',';
            }
        }
        document.getElementById("val").value = j;
    }

    window.onload = function () {
        showImage();

        var submitbtn_update = document.getElementById("bttsubmit_update");
        submitbtn_update.onclick = finish;
    }



</script>

<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<input type='file' id="upload" name="uploadedFile" onchange="readURL(this);" /> <br />
<input type="button" id="multiPosition" value="Next Area" class="btn" onclick="markMultiplePosition()" >


<input type="hidden" id="val" name="val">



