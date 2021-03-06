$(document).ready(function () {
    // $('.summernote-full').summernote({
    //         height: 200,
    //         toolbar: [
    //             ['style', ['style']],
    //             ['font', ['bold', 'italic', 'underline', 'clear']],
    //             // ['fontname', ['fontname']],
    //             ['color', ['color']],
    //             ['para', ['ul', 'ol', 'paragraph']],
    //             // ['height', ['height']],
    //             ['table', ['table']],
    //             ['insert', ['link', 'picture', 'hr']],
    //             ['view', ['fullscreen', 'codeview']],F
    //             ['help', ['help']],
    //         ],
    //
    //         onPaste: function(content) {
    //             console.log("ss");
    //             setTimeout(function () {
    //                 editor.code(content.target.textContent);
    //             }, 10)
    //         }
    //     }
    // );
    var editor = new MediumEditor('.medium-default',{  /* These are the default options for the editor,
        if nothing is passed this is what is used */
        activeButtonClass: 'medium-editor-button-active',
        allowMultiParagraphSelection: true,
        buttonLabels: false,
        contentWindow: window,
        delay: 0,
        disableReturn: false,
        disableDoubleReturn: false,
        disableExtraSpaces: false,
        disableEditing: false,
        elementsContainer: false,
        extensions: {},
        ownerDocument: document,
        spellcheck: true,
        targetBlank: false});

    $('.medium-default').css('min-height','250px').css('overflow','auto');
    $(function () {
        $('.medium-default').mediumInsert({
            editor: editor
        });
    });
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