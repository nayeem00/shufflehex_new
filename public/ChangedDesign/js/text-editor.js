$(document).ready(function () {
    $('.summernote-full').summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                // ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                // ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'hr']],
                ['view', ['fullscreen', 'codeview']],
                ['help', ['help']],
            ],

            onPaste: function(content) {
                console.log("ss");
                setTimeout(function () {
                    editor.code(content.target.textContent);
                }, 10)
            }
        }
    );
    $('.summernote-short').summernote({
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            // ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize', 'fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']]
        ],
        height: 200,
    });

    $('.summernote-review').summernote({
        toolbar: [
            // ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            // ['fontname', ['fontname']],
            // ['color', ['color']],
            ['para', ['ul', 'ol']],
            // ['height', ['height']],
            // ['table', ['table']],
            ['insert', ['picture']],
            // ['view', ['fullscreen', 'codeview']],
            // ['help', ['help']]
        ],


        height: 120,
        popover: {
            image: [
                ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                ['float', ['floatLeft', 'floatRight', 'floatNone']],
                ['remove', ['removeMedia']]
            ],
        }
    })

})