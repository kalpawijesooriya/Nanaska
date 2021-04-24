<script type="text/javascript">

window.onload = function (){

//    var success = new PDFObject({ url:<?php // echo Yii::app()->baseUrl . '/images/exhibit_attachment/' . $qid . '/' . $pdf; ?> }).embed("pdf");
    
};



</script>

<?php
//$this->widget('ext.pdfJs.QPdfJs',array(
//  'url'=>'http://www.energy.umich.edu/sites/default/files/pdf-sample.pdf?id=1&format='));
?>

<div id="pdf">It appears you don't have Adobe Reader or PDF support in this web browser. <a href="<?php echo Yii::app()->getBaseUrl(true) . '/images/exhibit_attachment/' . $qid . '/' . $pdf; ?>">Click here to download the PDF</a></div>