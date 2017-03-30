/*
var WYSIWYGEditor = (function(){
    var _elementId;
    //var $ = jQuery.noConflict();

    return{
        init:function(elementId){
            _elementId = elementId;

            var editor = tinymce.init({
                selector: "#"+elementId,
                language: 'ru',
                statusbar: false,
                skin:"black",
                resize: false,
                menubar: false,
                plugins: 'image lists link media table',
                automatic_uploads: true,
                relative_urls: false,
                remove_script_host: false,
                media_live_embeds: true,
                toolbar: "undo redo | bold italic | bullist numlist | table | image list link media",
                content_style: ".mce-content-body {font-size:15px;font-family:Arial,sans-serif;}",
                images_upload_url: '../../../div0/ImageUploader.php',
                // here we add custom filepicker only to Image dialog
                file_picker_types: 'image',
                // and here's our custom image picker
                file_picker_callback: function(cb, value, meta) {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.onchange = function() {
                        var file = this.files[0];

                        console.log("file",file);

                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache = tinymce.activeEditor.editorUpload.blobCache;

                        var blobInfo = blobCache.create(id, file);
                        blobCache.add(blobInfo);

                        console.log("blobInfo.blobUri()",blobInfo.blobUri());
                        console.log("blobInfo",blobInfo);
                        console.log("file.name",file.name);

                        // call the callback and populate the Title field with the file name
                        cb(blobInfo.blobUri(), { title: file.name });
                    };

                    input.click();
                }
            });
        },
        destroy:function(){
            console.log("destroy from "+_elementId);
            tinymce.execCommand('mceRemoveControl', true, _elementId);
        }
    }
})();
*/


var WYSIWYGEditor = function(){
    var _elementId;

    var $ = jQuery.noConflict();

    return{
        initOnHtmlElement:function(element){
            var editor = tinymce.init({
                target: element,
                language: 'ru',
                statusbar: false,
                skin:"black",
                resize: false,
                menubar: false,
                plugins: 'image lists link media table',
                automatic_uploads: true,
                relative_urls: false,
                remove_script_host: false,
                media_live_embeds: true,
                toolbar: "undo redo | bold italic | bullist numlist | table | image list link media",
                content_style: ".mce-content-body {font-size:15px;font-family:Arial,sans-serif;}",
                images_upload_url: '../../../div0/ImageUploader.php',
                // here we add custom filepicker only to Image dialog
                file_picker_types: 'image',
                // and here's our custom image picker
                file_picker_callback: function(cb, value, meta) {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.onchange = function() {
                        var file = this.files[0];

                        console.log("file",file);

                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache = tinymce.activeEditor.editorUpload.blobCache;

                        var blobInfo = blobCache.create(id, file);
                        blobCache.add(blobInfo);

                        console.log("blobInfo.blobUri()",blobInfo.blobUri());
                        console.log("blobInfo",blobInfo);
                        console.log("file.name",file.name);

                        // call the callback and populate the Title field with the file name
                        cb(blobInfo.blobUri(), { title: file.name });
                    };

                    input.click();
                }
            });
        },
        
        initOnEveryTextArea:function(){
            var editor = tinymce.init({
                selector: "textArea",
                language: 'ru',
                statusbar: false,
                skin:"black",
                resize: false,
                menubar: false,
                plugins: 'image lists link media table',
                automatic_uploads: true,
                relative_urls: false,
                remove_script_host: false,
                media_live_embeds: true,
                toolbar: "undo redo | bold italic | bullist numlist | table | image list link media",
                content_style: ".mce-content-body {font-size:15px;font-family:Arial,sans-serif;}",
                images_upload_url: '../../../div0/ImageUploader.php',
                // here we add custom filepicker only to Image dialog
                file_picker_types: 'image',
                // and here's our custom image picker
                file_picker_callback: function(cb, value, meta) {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.onchange = function() {
                        var file = this.files[0];

                        console.log("file",file);

                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache = tinymce.activeEditor.editorUpload.blobCache;

                        var blobInfo = blobCache.create(id, file);
                        blobCache.add(blobInfo);

                        console.log("blobInfo.blobUri()",blobInfo.blobUri());
                        console.log("blobInfo",blobInfo);
                        console.log("file.name",file.name);

                        // call the callback and populate the Title field with the file name
                        cb(blobInfo.blobUri(), { title: file.name });
                    };

                    input.click();
                }
            });
        },
        
        
        init:function(elementId){
            _elementId = elementId;
            
            var editor = tinymce.init({
                selector: "#"+elementId,
                language: 'ru',
                statusbar: false,
                skin:"black",
                resize: false,
                menubar: false,
                plugins: 'image lists link media table',
                automatic_uploads: true,
                relative_urls: false,
                remove_script_host: false,
                media_live_embeds: true,
                toolbar: "undo redo | bold italic | bullist numlist | table | image list link media",
                content_style: ".mce-content-body {font-size:15px;font-family:Arial,sans-serif;}",
                images_upload_url: '../../../div0/ImageUploader.php',
                // here we add custom filepicker only to Image dialog
                file_picker_types: 'image',
                // and here's our custom image picker
                file_picker_callback: function(cb, value, meta) {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.onchange = function() {
                        var file = this.files[0];

                        console.log("file",file);
                        
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache = tinymce.activeEditor.editorUpload.blobCache;

                        var blobInfo = blobCache.create(id, file);
                        blobCache.add(blobInfo);

                        console.log("blobInfo.blobUri()",blobInfo.blobUri());
                        console.log("blobInfo",blobInfo);
                        console.log("file.name",file.name);

                        // call the callback and populate the Title field with the file name
                        cb(blobInfo.blobUri(), { title: file.name });
                    };

                    input.click();
                }
            });
        },
        destroy:function(_elementId){
            //console.log("destroy from "+_elementId);
            //tinymce.execCommand('mceRemoveControl', true, _elementId);
        },
        getContent:function(){
            return "CONTENT";
        },
        setContent:function(data){
            //$("#"+_elementId).summernote("code", data);
        }
    }
}
