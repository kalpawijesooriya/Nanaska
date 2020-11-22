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

<div class="cols" style="">
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
            
                echo '<div  class="box">
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

.cols {
    column-count: 2;
    -moz-column-count: 2;
    -webkit-column-count: 2;
    width: 97%;
    margin-left:20px;
    margin-right:20px;
    
}
.box {
    margin-bottom: 25px;    border:1px solid; border-color: #D1D0CE; border-radius: 25px;

}



.box, .dummy {
    display: inline-block;
  
    width: 100%;
}
</style>

