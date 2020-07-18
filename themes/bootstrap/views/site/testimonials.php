<div class="breadcrumb-banner-area" style="height:100px">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-text">
                    <h1 class="text-center">Testimonials</h1>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<br>

<div div id="container" class="cols">
<?php
$modeltestimonials = new Testimonials();
$data=  $modeltestimonials->getTestimonials();
        if (empty($data)) {
            echo '<div class="well">';
            echo '<center><b>Testimonials not available</b></center>';
            echo '</div>';
        } else {
            $status=1;
            foreach ($data as $item) {
            
                echo '<div  class="box one" style="margin-right:30px">
                        <div class="row"  style="padding:20px">
                           <p style="text-align:justify!important; text-justify:inner-word!important;">'.$item['testimonials_description'].'</p>
                        </div>
                        <div class="row" >
                            <div class="col col-lg-2">
                                <img src="'.$item['image_url'].'"  alt="testimonial 1" style="width:100px;height:100px;border-radius: 50%;" />
                            </div>
                            <div class="col col-lg-10">
                            <h5 style="color:#848482;margin-top:30px;margin-left:20px">'.$item['testimonials_name'].'</h5>
                            </div>
                        </div>
                      </div>';

        }
    }

?>
</div>

<style>
#container {
    width: 100%;

    margin: 2em 1em;
}
.cols {
    -moz-column-count:2 !important ;
    -moz-column-gap: 3%!important ;
    -moz-column-width: 100%!important ;
    -webkit-column-count:2!important ;
    -webkit-column-gap: 3%!important ;
    -webkit-column-width: 100%!important ;
    column-count: 2!important ;
    column-gap: 3%!important ;
    column-width: 100%!important ;
}
.box {
    margin-bottom: 25px;
}

.box.one {
    height: auto;

    border:1px solid; border-color: #D1D0CE; border-radius: 25px;
    margin-right:1em;
}
.box.two {
    height: 300px;
    background-color: #dcbc4c;
}
.box.three {
    background-color: #a3ca3b;
    height: 400px;
}
.box.four {
    background-color: #3daee3;
    height: 500px;
}
.box.five {
    background-color: #bb8ed8;
    height: 600px;
}
.box.six {
    background-color: #baafb1;
    height: 200px;
}
</style>

