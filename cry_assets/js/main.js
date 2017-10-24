function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                jQuery('#blah')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
jQuery(document).click(function(){
    if (jQuery("#optionsRadios3").is(':checked')||(jQuery('#optionsRadios31').is(':checked')||jQuery('#optionsRadios32').is(':checked'))){
        jQuery("#demo1").css("display","block");
    }
    else {
        jQuery("#demo1").css("display","none");
    }
    if(jQuery('#optionsRadios31').is(':checked')||jQuery('#optionsRadios32').is(':checked')){
        jQuery("#demo2").css("display","block");
    }
    else {
        jQuery("#demo2").css("display","none");
    }
    if (jQuery('#optionsRadios33').is(':checked')){
        jQuery("#optionsRadios1").prop("checked", true);
    }

    if ($("#grp").prop('checked') == true){
        $("#grap").css("display","block");
        $("#st").prop("required","required");
        $("#en").prop("required","required");
    }
    else {
        $("#grap").css("display","none");
        $("#st").removeAttr('required');
        $("#en").removeAttr('required');
    }

    if ($("#noe").prop('checked') == true){
        $("#not").css("display","block");
    }
    else {
        $("#not").css("display","none");
        
    }

     if ($("#pot").prop('checked') == true){
        $("#port").css("display","block");
        $("#port_set").prop("required","required");
        
    }
    else {
        $("#port").css("display","none");
        $("#port_set").removeAttr('required');
       
    }


})

$(document).on('click', '.btn-add', function(e)
    {
        console.log("dmm");
        e.preventDefault();
        console.log("2");
        var controlForm = $('.controls'),
            currentEntry = $(this).parents('.entry:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');
        controlForm.find('.entry:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="glyphicon glyphicon-minus"></span>');
    }).on('click', '.btn-remove', function(e)
    {
        $(this).parents('.entry:first').remove();

        e.preventDefault();
        return false;
    });


$(document).ready(function(){
    
    $("span.removes").click(function(){
        
        $(this).closest("li").remove();
    });


    $(".val_pie").change(function(){
        var id = $(this).data("tid");
        var val = $(this).val();
         
    });

    $(".nam_pie").change(function(){
        var id = $(this).data("tid");
        var val = $(this).val();
        console.log(val);
    });
   
    $('#pdf_create').on('click', function() {
        
        var doc     = new jsPDF();
        var canvas_line = $('#port_data');
        var canvas_pie = $('#pieChart');
        var pdf_comment = $('.pdf_comment'); 

        var line    = $('.line');
        var pdf_img = $('#pdf_img')[0]; 
        
        var pdf_title = $('.pdf_title');   
        var title = new Array();
        for (var i = 0; i < pdf_title.length; i++) {
            title.push(pdf_title[i].outerText);
        }

        var pdf_mini_title = $('.pdf_mini_title');   
        var mini_title = new Array();
        for (var i = 0; i < pdf_mini_title.length; i++) {
            mini_title.push(pdf_mini_title[i].outerText);
        }

        var pdf_mini_content = $('.pdf_mini_content');   
        var mini_content = new Array();
        for (var i = 0; i < pdf_mini_content.length; i++) {
            mini_content.push(pdf_mini_content[i].outerText);
        }

        var pdf_value = $('.pdf_value');   
        var value = new Array();
        for (var i = 0; i < pdf_value.length; i++) {
            value.push(pdf_value[i].outerText);
        }

        var pdf_content = $('.pdf_content');
        var content = new Array();
        for (var i = 0; i < pdf_content.length; i++) {
            content.push(pdf_content[i].outerText);
        }

        var pdf_content_1 = $('.pdf_content_1'); 
        var content_1 = new Array();
        for (var i = 0; i < pdf_content_1.length; i++) {
            content_1.push(pdf_content_1[i].outerText);
        }

        var pdf_content_2 = $('.pdf_content_2'); 
        var content_2 = new Array();
        for (var i = 0; i < pdf_content_2.length; i++) {
            content_2.push(pdf_content_2[i].outerText);
        }

        var margin_top = 10;
        var height_logo = 50;
        for (var i = 0; i < line.length; i++) {
            //set text title
            if (title.includes(line[i].outerText)) {
                doc.setFont("helvetica");
                doc.setFontSize(10);
                doc.text(20, margin_top + 5*i, line[i].outerText);

                if (line[i].outerText === 'Logo Fund :') {
                    if (pdf_img !== 'undefined'){
                        function getBase64Image(img) {
                            var canvas = document.createElement("canvas");
                            var ctx = canvas.getContext("2d");

                            canvas.width  = 300;
                            canvas.height = 300; 
                            ctx.drawImage(img, 0, 0, canvas.width , canvas.height);

                            return canvas.toDataURL("image/png");
                        }
                        var logo_img = getBase64Image(pdf_img);
                        doc.addImage(logo_img, 'PNG', 25, margin_top + 5*(i+1), 50, height_logo);
                        margin_top = margin_top + height_logo +10;
                    }
                }

                if (line[i].outerText === 'Performance Graph') {
                    if (typeof canvas_line !== 'undefined') {
                        try {
                            var img_line = canvas_line[0].toDataURL("image/png");
                            doc.addImage(img_line, 'PNG', 30, margin_top + 5*(i+1), 120, 90);
                        } catch(e) {
                            // statements
                            console.log(e);
                        }
  
                        margin_top = margin_top + height_logo + 50;
                    } 
                }

                if (line[i].outerText === 'Shares Info') {
                    if (typeof canvas_pie !== 'undefined') {
                        try {
                            var img_pie = canvas_pie[0].toDataURL("image/png");
                            doc.addImage(img_pie, 'PNG', 20, margin_top + 5*(i+1), 75, 75); 
                        } catch(e) {
                            // statements
                            console.log(e);
                        } 
                        

                        for (var k = 0; k < pdf_comment.length; k++) {

                            function rgb2hex(rgb){
                                rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
                                return (rgb && rgb.length === 4) ? "#" +
                                        ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
                                        ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
                                        ("0" + parseInt(rgb[3],10).toString(16)).slice(-2) : '';
                            }

                            var color = $('#comment_'+k).css('background');
                            color = color.split("none")[0];

                            var color_text = rgb2hex(color);

                            doc.setTextColor(color_text);
                            doc.text(115, margin_top + 5*(i+1) + 5*k, pdf_comment[k].outerText);
                            doc.setTextColor(0,0,0);
                        }

                        margin_top = margin_top + height_logo + 35;
                    } 
                }
                
            //set text content   
            } else if ( content.includes(line[i].outerText) || mini_title.includes(line[i].outerText) ) {
                doc.setFont("times");
                doc.setFontSize(8);
                doc.text(40, margin_top + 5*i, line[i].outerText);
            //set text notes
            } else if (content_1.includes(line[i].outerText)) {

                doc.setFont("times");
                doc.setFontSize(8);
                doc.text(30, margin_top + 5*i, line[i].outerText);
                var margin_top_note = margin_top + 5*i;
                margin_top = margin_top -5;
            //set text date of note
            } else if (content_2.includes(line[i].outerText)) {

                doc.setFont("times");
                doc.setFontSize(8);
                doc.text(150, margin_top_note, line[i].outerText, null, null, 'center');

            } else if (mini_content.includes(line[i].outerText)) {

                doc.setFont("times");
                doc.setFontSize(8);
                doc.text(40, margin_top + 5*i, line[i].outerText);
                var margin_top_value = margin_top + 5*i;
                margin_top = margin_top -5;

            } else if (value.includes(line[i].outerText)) {
                doc.setFont("times");
                doc.setFontSize(8);
                doc.text(80, margin_top_value, line[i].outerText);
            } 
        }

        doc.save('download.pdf');
    });
});