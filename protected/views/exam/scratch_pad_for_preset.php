<textarea id="scratch_preset"></textarea>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins/tinymce/js/tinymce/tinymce.min.js"></script>

<script>

    tinymce.init({
        selector: "#scratch_preset",
       // theme: "modern",
        plugins: "autoresize",
//        editor_selector: "mceEditor",
//        editor_deselector: "mceNoEditor",
//        plugins: [
//            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
//            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
//            "save table contextmenu directionality emoticons template paste textcolor jbimages"
//        ],
      //  content_css: "css/content.css",
        toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l   |  | forecolor backcolor",
        relative_urls: false,
        style_formats: [
            {title: 'Bold text', inline: 'b'},
            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
            {title: 'Example 1', inline: 'span', classes: 'example1'},
            {title: 'Example 2', inline: 'span', classes: 'example2'},
            {title: 'Table styles'},
            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
        ]


    });
</script>
