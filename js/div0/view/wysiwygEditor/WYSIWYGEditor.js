//http://summernote.org/
var WYSIWYGEditor = function(){
    var _elementId;

    var $ = jQuery.noConflict();

    return{
        init:function(elementId){
            _elementId = elementId;

            console.log("elementId="+elementId);

            var editor = tinymce.init({
                selector:elementId,
                language: 'ru',
                statusbar: false,
                skin:"black",
                resize: false,
                menubar: false,
                plugins: 'image',
                automatic_uploads: true,
                images_upload_url: 'postAcceptor.php',
                // here we add custom filepicker only to Image dialog
                file_picker_types: 'image',
                // and here's our custom image picker
                file_picker_callback: function(cb, value, meta) {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    // Note: In modern browsers input[type="file"] is functional without
                    // even adding it to the DOM, but that might not be the case in some older
                    // or quirky browsers like IE, so you might want to add it to the DOM
                    // just in case, and visually hide it. And do not forget do remove it
                    // once you do not need it anymore.

                    input.onchange = function() {
                        var file = this.files[0];

                        console.log("file",file);

                        // Note: Now we need to register the blob in TinyMCEs image blob
                        // registry. In the next release this part hopefully won't be
                        // necessary, as we are looking to handle it internally.
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache = tinymce.activeEditor.editorUpload.blobCache;

                        var blobInfo = blobCache.create(id, file);
                        blobCache.add(blobInfo);

                        console.log("blobInfo.blobUri()",blobInfo.blobUri());


                        // call the callback and populate the Title field with the file name
                        cb(blobInfo.blobUri(), { title: file.name });
                    };

                    input.click();
                }
            });
            console.log("editor:",editor);

        },
        destroy:function(){
            //$("#"+_elementId).summernote("destroy");
        },
        getContent:function(){
            return "CONTENT";
        },
        setContent:function(data){
            //$("#"+_elementId).summernote("code", data);
        }
    }
}
