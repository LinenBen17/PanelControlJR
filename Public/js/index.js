var modal = $('#editorCropper'); 
var noGuia = $('#no_guia');
var image = document.getElementById('image');
var cropper,reader,file;


$("body").on("change", ".image", function(e) {
    var files = e.target.files;
    var done = function(url) {
        image.src = url;
        modal.modal()

    };


    if (files && files.length > 0) {
        file = files[0];

        if (URL) {
            done(URL.createObjectURL(file));
        } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function(e) {
                done(reader.result);
            };
            reader.readAsDataURL(file);
        }
    }
});
modal.on($.modal.OPEN, function() {
    cropper = new Cropper(image, {
        viewMode: 1,
        preview: '.preview'
    });
    $('.rotate45').click(function(){
        cropper.rotate(45)
        
    })
    $('.moveCenter').click(function(){
        cropper.setDragMode('move')
    })
});
modal.on($.modal.CLOSE, function() {
    cropper.destroy();
    cropper = null;
});

$("#crop").click(function() {
    if (noGuia.val().length >= 6) {    
        canvas = cropper.getCroppedCanvas();

        canvas.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
                var base64data = reader.result;

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "upload.php",
                    data: {
                        image: base64data,
                        no_guia: noGuia.val()
                    },
                    success: function(data) { 
                        $.modal.close();
                        if (data == "1") {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'La imagen ha sido subida correctamente.',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }
                });
            };
        });
    }else{
        $.modal.close();
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'El campo "No. Guía, está vacío o tiene insuficientes carácteres. ¡Intentalo de nuevo!.',
            showConfirmButton: false,
            timer: 2500
        });

    }
});