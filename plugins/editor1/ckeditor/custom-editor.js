var editorMarginLeft = 0, editorMarginTop = 0;
var editorWidth = 690;
var typingTimerContent;
var doneTypingIntervalContent = 1500;
if (CustomWidthEditor === -1) {
    editorWidth = $(window).width() - 180;
} else if (CustomWidthEditor > 0 ) {
    editorWidth = CustomWidthEditor;
}
if (editorWidth > widthWindows) {
    editorWidth = widthWindows - 50;
}
var editorHeight = 0;
if (customHeightEditor === 0) {
    editorHeight = heightWindows - $(".site-header").height() - (widthWindows < 800 ? 270 : 160);
} else {
    editorHeight = customHeightEditor;
}
var dialogVideoYoutube = new HDialog("embedYoutube", "Nhúng video youtube", "", 0, 0, "");
var dialogLink = new HDialog("mylink", "Gắn link", "#btnLink", 0, 0, "");
var isFirefox = navigator.userAgent.indexOf('Firefox') > -1;
tinymce.init({
    selector: mainEditor,
    branding: false,
    oninit: "setPlainText",
    extended_valid_elements: "div[onclick|title|class|id]",
    images_dataimg_filter: function (img) {
        return img.hasAttribute('internal-blob');
    },
    invalid_elements: 'header,article',
    //valid_children: '+p[span]',
    //contextmenu
    // plugins: ['paste,code,hlink,himage,table', 'searchreplace visualblocks code fullscreen', 'insertdatetime media table  paste code help wordcount'], /*testing plugin*/
    plugins: ['paste,code,hlink,himage,hvideo,hyoutube,table,wordcount,textcolor colorpicker searchreplace'], /*add plugins*/
    toolbar: 'himage hvideo hyoutube gallery | hlink quotes table code | bold,italic,underline | alignLeft alignCenter alignRight alignJustify listNumber listBullet | forecolor other', /*show object in toolbar options*/
    //contextmenu: "bold italic underline table",

    menubar: false, /*disable menu bar*/
    width: editorWidth, /*set width editor*/
    height: editorHeight, /*set height editor*/
    //end_container_on_empty_block: true,
    //allow_html_in_named_anchor: true,
    //extended_valid_elements: 'video',
    object_resizing: false,
    //content_css: ['/editor/css/content.css?v=1.2.0'],/*custom css in content*/

    content_css: [mobileVersion === "true" ? '/editor/css/content-mobile.css?v=0.0.3' : '/editor/css/content.css?v=0.0.3', mobileVersion !== "true" && ControlSepecial === "true" ? "/editor/css/magazine.css" : "/editor/css/none.css" ],/*custom css in */
    //style_formats: [
    //    { title: 'Bold text', inline: 'b' },
    //    { title: 'Red text', inline: 'span', styles: { color: '#ff0000' } }
    //],
    formats: {
        indent: { selector: '*', classes: 'indent-text' },
        outdent: { selector: '*', classes: 'outdent-text' },
        underline: { inline: 'u', exact: true },
        alignleft: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', exact: true },
        aligncenter: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'aligncenter' },
        alignright: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'alignright' },
        alignfull: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'alignfull' }
    },   
    //style_formats_autohide: true,
    //paste_as_text: true,
    paste_data_images:true,
    paste_postprocess: function (plugin, args) {
        var targetNode = args.target.selection.getNode();
        if (targetNode.localName === "figcaption" && targetNode.className === "image-caption") return false;    
        var newContent = args.node.innerHTML;
        $.ajax({
            url: "/action/processpaste.ashx",
            type: "POST",
            async: false,
            data: { 'data': newContent },
            beforeSend: function (ld) {
                HAlert('<p class="processPaste">Đang xử l&yacute; nội dung được sao ch&eacute;p ...</p>');
            },
            error: function (xhr, resp, text) {
                FAlert("Xử lý nội dung sao chép bị lỗi");
                console.log(xhr, resp, text);
            }
        }).done(function (data) {
            HAlert("Sao chép thành công");
            newContent = data;

        });
        args.node.innerHTML = newContent;
    },
    paste_preprocess: function (plugin, args) {
        var targetNode = args.target.selection.getNode();
        //Nếu người dùng paste nội dung vào thẻ figcaption thì format chỉ lấy text
        if (targetNode.localName === "figcaption" && targetNode.className === "image-caption") {
            var node = document.createElement("div");
            node.innerHTML = args.content;
            args.content = node.innerText;
            return false;
        }

    },
    setup: function (editor) {
            

        editor.addButton('other', {
            tooltip: 'Khác',
            type: 'menubutton',
            icon: true, image: '/editor/images/toolbar/more.png',
            menu: [
                {
                    tooltip: 'Xóa liên kết',
                    icon: true, image: '/editor/images/toolbar/unlink.png',
                    onclick: function () {
                        if (tinymce.activeEditor.selection.getNode().nodeName === "A") {
                            var text = tinymce.activeEditor.selection.getNode().text;
                            tinymce.activeEditor.selection.getNode().remove();
                            tinymce.activeEditor.selection.setContent(text);
                        }
                        console.dir(tinymce.activeEditor.selection.getNode());
                        console.dir(tinymce.activeEditor.selection);
                    }
                },
                {
                    tooltip: 'Quản lý file',
                    icon: true, image: '/editor/images/toolbar/file.png',
                    onclick: function () {
                        dialogFiles.Show();
                        Files.SelectPaging("", Client.UserID, "", "", 1);
                    }
                },
                {
                    tooltip: 'Kiểu chữ in hoa',
                    icon: true, image: '/editor/images/toolbar/uppercase.png',
                    onclick: function () {
                        editor.selection.setContent(htmlDecode(editor.selection.getContent()).toUpperCase());
                    }
                },
                {
                    tooltip: 'Kiểu chữ thường',
                    icon: true, image: '/editor/images/toolbar/lowercase.png',
                    onclick: function () {
                        editor.selection.setContent(htmlDecode(editor.selection.getContent()).toLowerCase());
                    }
                },
                {
                    tooltip: 'In hoa chữ cái đầu',
                    icon: true, image: '/editor/images/toolbar/capitalize.png',
                    onclick: function () {
                        editor.selection.setContent(htmlDecode(editor.selection.getContent()).toLowerCase().replace(/\b\w/g, l => l.toUpperCase()));
                    }
                },
                {
                    tooltip: 'Số mũ',
                    icon: true, image: '/editor/images/toolbar/sup.png',
                    onclick: function () {
                        editor.selection.setContent("<sup>" + editor.selection.getContent() + "</sup>");
                    }
                },
                {
                    tooltip: 'Chỉ số dưới',
                    icon: true, image: '/editor/images/toolbar/sub.png',
                    onclick: function () {
                        editor.selection.setContent("<sub>" + editor.selection.getContent() + "</sub>");
                    }
                }
            ]

        });
        editor.addButton('gallery', {
            tooltip: 'Gallery',
            type: 'menubutton',
            icon: true, image: '/editor/images/toolbar/gallery.png',
            menu: [
                {
                    tooltip: 'Gallery 2 ảnh',
                    classes: 'gallery-item',
                    icon: true, image: '/editor/images/toolbar/thumb-2.png',
                    onclick: function () {
                        editor.insertContent(`<div class="box-image twin"><div class="content-image"></div><div class="content-image"></div> <div class="cms-control"><div title="Xóa gallery" onclick="this.parentElement.parentElement.remove()" class="icon-close"></div></div></div><p>&nbsp;</p>`);
                    }
                },
                {
                    tooltip: 'Gallery 3 ảnh',
                    classes: 'gallery-item',
                    icon: true, image: '/editor/images/toolbar/thumb-3.png',
                    onclick: function () {
                        editor.insertContent('<div class="box-image triple"><div class="item"></div><div class="item"></div><div class="item"></div><div class="cms-control"><div title="Xóa gallery"  onclick="this.parentElement.parentElement.remove()" onclick="this.parentElement.parentElement.remove()" class="icon-close"></div></div></div><p>&nbsp;</p>');
                    }
                },
                {
                    tooltip: 'Gallery 4 ảnh',
                    classes: 'gallery-item',
                    icon: true, image: '/editor/images/toolbar/thumb-4.png',
                    onclick: function () {
                        editor.insertContent('<div class="box-image four"><div class="item"></div><div class="item"></div><div class="item"></div><div class="item"></div><div class="cms-control"><div title="Xóa gallery"  onclick="this.parentElement.parentElement.remove()" class="icon-close"></div></div></div><p>&nbsp;</p>');
                    }
                },
                {
                    tooltip: 'Gallery 5 ảnh',
                    classes: 'gallery-item',
                    icon: true, image: '/editor/images/toolbar/thumb-5.png',
                    onclick: function () {
                        editor.insertContent('<div class="box-image five"><div class="item"></div><div class="item"></div><div class="item item-sm"></div><div class="item item-lg"></div><div class="item item-lg"></div><div class="cms-control"><div title="Xóa gallery"  onclick="this.parentElement.parentElement.remove()" class="icon-close"></div></div></div><p>&nbsp;</p>');
                    }
                },
                {
                    tooltip: 'Gallery 6 ảnh',
                    classes: 'gallery-item',
                    icon: true, image: '/editor/images/toolbar/thumb-6.png',
                    onclick: function () {
                        editor.insertContent('<div class="box-image grid"><div class="item item-horizontal"></div><div class="item item-horizontal"></div><div class="item item-vertical"></div><div class="item item-vertical"></div><div class="item item-horizontal"></div><div class="item item-horizontal"></div><div class="cms-control"><div title="Xóa gallery"  onclick="this.parentElement.parentElement.remove()" class="icon-close"></div></div></div><p>&nbsp;</p>');
                    }
                },
                {
                    tooltip: 'Gallery 7 ảnh',
                    classes: 'gallery-item',
                    icon: true, image: '/editor/images/toolbar/thumb-7.png',
                    onclick: function () {
                        editor.insertContent('<div class="box-image seven"><div class="item item-lg"></div><div class="item item-lg"></div><div class="item"></div><div class="item"></div><div class="item item-sm"></div><div class="item item-lg"></div><div class="item item-lg"></div><div class="cms-control"><div title="Xóa gallery"  onclick="this.parentElement.parentElement.remove()" class="icon-close"></div></div></div><p>&nbsp;</p>');
                    }
                },
                {
                    tooltip: 'Gallery 8 ảnh',
                    classes: 'gallery-item',
                    icon: true, image: '/editor/images/toolbar/thumb-8.png',
                    onclick: function () {
                        editor.insertContent('<div class="box-image eight"><div class="item item-horizontal"></div><div class="item item-horizontal"></div><div class="item item-vertical"></div><div class="item item-vertical"></div><div class="item item-horizontal"></div><div class="item item-horizontal"></div><div class="item item-lg"></div><div class="item item-lg"></div><div class="cms-control"><div title="Xóa gallery"  onclick="this.parentElement.parentElement.remove()" class="icon-close"></div></div></div><p>&nbsp;</p>');
                    }
                }
            ]

        });
        editor.addButton('quotes', {
            tooltip: 'Chèn box nhúng',
            icon: true, image: '/editor/images/toolbar/insertQuote.png',
            onclick: function () {
                editor.insertContent('<div class="quotes"><label title="Thiết lập box nhúng" class="settings"></label><p></p></div>');
            }
        });
        editor.addButton('alignLeft', {
            tooltip: 'Căn lề trái', id: 'alignLeft',
            icon: true, image: '/editor/images/toolbar/alignLeft.png',
            onclick: function () { Editor.AlignLeft(); }
        });
        editor.addButton('alignRight', {
            tooltip: 'Căn lề phải', id: 'alignRight',
            icon: true, image: '/editor/images/toolbar/alignRight.png',
            onclick: function () { Editor.AlignRight(); }
        });
        editor.addButton('alignCenter', {
            tooltip: 'Căn giữa', id: 'alignCenter',
            icon: true, image: '/editor/images/toolbar/alignCenter.png',
            onclick: function () { Editor.AlignCenter(); }
        });
        editor.addButton('alignJustify', {
            tooltip: 'Căn đều', id: 'alignJustify',
            icon: true, image: '/editor/images/toolbar/alignJustify.png',
            onclick: function () { Editor.AlignJustify(); }
        });
        editor.addButton('listNumber', {
            tooltip: 'Danh sách kiểu số', id: 'listNumber',
            icon: true, image: '/editor/images/toolbar/listNumber.png',
            onclick: function () { Editor.ListNumber(); }
        });
        editor.addButton('listBullet', {
            tooltip: 'Danh sách kiểu ký tự', id: 'listBullet',
            icon: true, image: '/editor/images/toolbar/listBullet.png',
            onclick: function () { Editor.ListBullet(); }
        });

    },
    init_instance_callback: function (editor) {
        /*Điều khiển sự kiện khi người dùng trỏ chuột vào 1 đối tượng bất kỳ*/
        var ed = tinymce.activeEditor;
        /*begin shortcut keys*/
        editor.shortcuts.add("ctrl+k", "Open dialog hyperlink", function () {
            Editor.Hyperlink();
        });
        editor.shortcuts.add("ctrl+r", "Align right", function () {
            Editor.AlignRight();
        });
        editor.shortcuts.add("ctrl+e", "Align center", function () {
            Editor.AlignCenter();
        });
        editor.shortcuts.add("ctrl+j", "Align justify", function () {
            Editor.AlignJustify();
        });
        editor.shortcuts.add("ctrl+l", "Align left", function () {
            Editor.AlignLeft();
        });
        editor.shortcuts.add("ctrl+p", "Insert picture", function () {
            Utils.BrowseImages();
        });
        /*end shortcut keys*/

        /*begin handle events*/
        editor.on('MouseUp', function (e) {
            if (ed.selection.getContent()) { //nếu người dùng chọn văn bản thì hiển thị toolbar văn bản
                if (ed.selection.getNode().nodeName !== "IMG") {
                    ChangePositionOtherToolbar(e.x, e.y);
                }
            }

            if (tinymce.activeEditor.selection.getNode().nodeName === "A") {
                $("#OtherToolbar span.icon-hyperlink").addClass('active-icon');
            } else {
                $("#OtherToolbar span.icon-hyperlink").removeClass('active-icon');
            }

        });
        /*handle double click event on editor*/
        editor.on('dblclick', function (e) {
            if (ed.selection.getNode().nodeName !== "IMG") {
                ChangePositionOtherToolbar(e.x, e.y);
            }
        });
        editor.on('click', function (e) {
            if (!ed.selection.getContent()) { //nếu người dùng click vào vùng trống thì ẩn các toolbar
                Editor.HideOtherToolbar(); //hide toolbar common
                Editor.HideImageTolbar(); //hide toolbar image
                $("#quoteToolbar").addClass('hidden');
            }
            if (tinymce.activeEditor.selection.getNode().nodeName === "IMG") {
                ChangePositionImageToolbar(e.x, e.y);
            } else if (tinymce.activeEditor.selection.getNode().nodeName === "LABEL" && tinymce.activeEditor.selection.getNode().className === "settings") {
                ChangePositionQuoteToolbar(e.x, e.y);
            } else if (tinymce.activeEditor.selection.getNode().nodeName !== "IMG" && !$("#imageToolbar").hasClass('hidden')) {
                $("#imageToolbar").addClass('hidden');
            }
        });
        /*điều khiển sự kiện khi người dùng mới di chuột vào các thành phần trên editor*/
        editor.on('mouseover', function (e) {
        });
        //editor.on('SetContent', function (e) {
        //    console.log(e.content);
        //});        

        //editor.on('PreProcess', function (e) {
        //    console.dir(e);
        //});
        //editor.on('PostProcess', function (e) {
        //    console.dir(e);
        //});
        //editor.on('ContextMenu', function (e) {
        //    var position = tinymce.DOM.getPos(ed.selection);
        //    ChangePositionOtherToolbar(position.x, position.y);
        //    return false;
        //});
        editor.on('mousemove', function (e) {

        });
        editor.on('mouseout', function (e) {

        });
        editor.on('KeyUp', function (e) {
            /*auto save sau 1.5 second when user typing */
            clearTimeout(typingTimerContent); typingTimerContent = setTimeout(AutoSave.SaveContent, doneTypingIntervalContent); 

        /*handle sự kiện khi người dùng select 1 đoạn văn bản */
            if (!ed.selection.isCollapsed()) {
                if (ed.selection.getNode().nodeName !== "IMG") {
                    ChangePositionOtherToolbar(e.x, e.y);
                }
            } else {
                Editor.HideOtherToolbar();
            }            
        });

        editor.on('Paste', function (e) {
            return false;
        });

        /*Điều khiển sự kiện khi người dùng thực hiện các tác vụ trên bàn phím*/
        editor.on('KeyDown', function (e) {
            //clear typingtimer for auto save
            clearTimeout(typingTimerContent); 

            ///handle backspace || delete press/
            if (e.keyCode === 8 || e.keyCode === 46) {
                var selectedNode = ed.selection.getNode(); // get selected node (element) in the editor  
                if (selectedNode && selectedNode.nodeName === 'IMG') {
                    if (selectedNode.parentNode.nodeName === "FIGURE") {
                        selectedNode.parentNode.remove();
                    }
                } else if (selectedNode && selectedNode.className.toString().indexOf('image-content') > -1) {
                    selectedNode.parentNode.remove();
                }
            }
            if (e.keyCode === 13) {
                //console.log(ed.selection.getNode().nodeName);
                //xử lý sự kiện khi người dùng enter ở thẻ div ảnh và thẻ p caption của ảnh
                //|| ed.selection.getNode().nodeName === "FIGURE"
                if (ed.selection.getNode().nodeName === "FIGCAPTION") {
                    var outerHtml = ed.selection.getNode().parentNode.outerHTML;
                    ed.selection.getNode().parentNode.remove();
                    tinymce.activeEditor.selection.setContent(outerHtml.replace('<br><br>', "") + "<p><br/></p>", { format: 'raw' });
                } else if (ed.selection.getNode().nodeName === "P" && ed.selection.getNode().className.indexOf('image-caption') > -1) {
                    var className = ed.selection.getNode().className;
                    var outerHtml = ed.selection.getNode().parentNode.outerHTML;
                    ed.selection.getNode().parentNode.remove();
                    tinymce.activeEditor.selection.setContent(outerHtml.replace('<p class="' + className + '"><br data-mce-bogus="1"></p>', "") + "<p><br/></p>", { format: 'raw' });
                } else if (ed.selection.getNode().nodeName === "P" && ed.selection.getNode().className.indexOf('video-caption') > -1) {
                    /*sự kiện khi enter vào video*/
                    var className = ed.selection.getNode().className;
                    var outerHtml = ed.selection.getNode().parentNode.outerHTML;
                    ed.selection.getNode().parentNode.remove();
                    tinymce.activeEditor.selection.setContent(outerHtml.replace('<p class="' + className + '"><br data-mce-bogus="1"></p>', "") + "<p><br/></p>", { format: 'raw' });
                } else if (ed.selection.getNode().nodeName === "DIV" && ed.selection.getNode().className.indexOf('quotes') > -1) {

                    /*sự kiện khi người dùng enter ở trong div quotes*/
                    /*
                     var ed = tinyMCE.get('txt_area_id');                // get editor instance
var range = ed.selection.getRng();                  // get range
var newNode = ed.getDoc().createElement ( "img" );  // create img node
newNode.src="sample.jpg";                           // add src attribute
range.insertNode(newNode);
                     */
                    return false;
                    //var range = ed.selection.getRng();
                    //console.dir(range);
                    //var newNode = ed.getDoc().createElement("p") //create p node
                    //console.log(newNode.outerHTML);
                    //ed.execCommand('mceInsertContent', false, newNode.outerHTML)



                }
                e.preventDefault();
                e.stopPropagation();
                return;
            }

            //active hyperlink
            if (tinymce.activeEditor.selection.getNode().nodeName === "A") {
                $("#OtherToolbar span.icon-hyperlink").addClass('active-icon');
            } else {
                $("#OtherToolbar span.icon-hyperlink").removeClass('active-icon');
            }

        });
        /*end handle events*/

    }/*end init_instance_callback function*/
});/*end tinymce editor*/

function doNothing() {

}

function test(encodedStr) {
    return $("<div/>").html(encodedStr).text();
}

function htmlDecode(input) {
    if (input === 'undefined' || input === '') return "";
    var e = document.createElement('div');
    e.innerHTML = input;
    return e.childNodes[0].nodeValue;
}

function ChangePositionImageToolbar(Left, Top) {
    if (Left === undefined) Left = 0;
    if (Left > 280) Left = 280;
    $("#imageToolbar").removeClass("hidden").css({
        "top": Top, "left": Left 
    });
}

function ChangePositionQuoteToolbar(Left, Top) {
    $("#quoteToolbar").removeClass("hidden").css({ "top": Top + 70, "left": Left + editorMarginLeft - 170 });
}

function ChangePositionOtherToolbar(Left, Top) {
    if (editorWidth < 500) return false;
    if (Left === undefined) Left = 0;   
    if (Left > 280) Left = 280;
    $("#OtherToolbar").removeClass("hidden").css({ "top": Top , "left": Left });
}
function getOffset() {
    var editorPosition = document.querySelector('#contain-editor').getBoundingClientRect();
    editorMarginLeft = editorPosition.left;
    editorMarginTop = editorPosition.top;
}
$(function () {
    setTimeout(getOffset, 1000);
    $("#btnTest").click(function () {
        $("#content").html(tinyMCE.editors[$(mainEditor).attr('id')].getContent());
    });
    //event when click hyperlink button
    $("#btnLink").click(function () {
        UpdateHyperlink();
    });
    //event when user press enter input hyperlink
    $("#txtLink").on('keypress', function (e) {
        if (e.keyCode === 13) {
            UpdateHyperlink(); dialogLink.Close();
            return false;
        }
    });

    function UpdateHyperlink() {

        var link = $("#txtLink").val();
        var nofollow = "";
        if ($('#chkNofollow').is(":checked")) nofollow = " rel='nofollow'";
        var target = $("#sltOpenLink").val() == "" ? "" : " target='_blank'";
        if (tinymce.activeEditor.selection.getNode().nodeName === "A") {
            //update: Lấy lại các thuộc tính của đối tượng gốc, gán vào các biến cần thiết. Remove đối tượng gốc và insert đối tượng mới
            var text = tinymce.activeEditor.selection.getNode().text;
            tinymce.activeEditor.selection.getNode().remove();
            tinymce.activeEditor.selection.setContent('<a href="{0}" title="{1}"{2}{3}>{1}</a>'.format(link, text, target, nofollow));
        } else {
            //insert

            tinymce.activeEditor.selection.setContent('<a href="{0}" title="{1}"{2}{3}>{1}</a>'.format($("#txtLink").val(), tinymce.activeEditor.selection.getContent(), target, nofollow));
        }
        //reset default value
        $("#txtLink").val('');
        $("#txtTitle").val('');
        $('#chkNofollow').removeAttr('checked');
        $("#sltOpenLink").val("");
    }

});




$(window).on('dblclick', function (e) {
    //console.log('double click');
});

$(".pragrap-before, .pragrap-after").click(function () {
    alert('11');
});

class Editor {
    static OpenQuoteToolbar() {
        $("#quoteToolbar").removeClass('hidden');
    }
    static EditImage() {
        Images.SelectPaging("", "", "", "", 1, 1, "#ul-Images");
        dialogImage.Show();
        Images.EditImage(tinymce.activeEditor.selection.getNode());
    }
    static AlignLeft() {
        if (tinymce.activeEditor.selection.getNode().nodeName != "IMG") {
            tinymce.activeEditor.execCommand("JustifyLeft");
            Editor.HideOtherToolbar();
        }
    }
    static AlignLeftImage() {
        Editor.RemoveAllAlgin();
        tinymce.activeEditor.dom.addClass(tinymce.activeEditor.selection.getNode().parentNode, "align-left-image");
    }
    static DoubleLeftImage() {

        Editor.RemoveAllAlgin();
        tinymce.activeEditor.dom.addClass(tinymce.activeEditor.selection.getNode().parentNode, "double-left-image");
    }
    static FullImage() {
        console.dir(tinymce.activeEditor.selection.getNode().outerHTML);
        Editor.RemoveAllAlgin();
        tinymce.activeEditor.dom.addClass(tinymce.activeEditor.selection.getNode().parentNode, "full-image");
        tinymce.activeEditor.selection.getNode().setAttribute("data-mce-src", tinymce.activeEditor.selection.getNode().src.replace("/w640", ""));
        var imageFormat = tinymce.activeEditor.selection.getNode().outerHTML.replace("/w640", "");
        console.log(imageFormat);
        tinymce.activeEditor.selection.setContent(imageFormat, { format: 'raw' });
    }
    static DoubleRightImage() {
        Editor.RemoveAllAlgin();
        tinymce.activeEditor.dom.addClass(tinymce.activeEditor.selection.getNode().parentNode, "double-right-image");
    }
    static AlignRightImage() {
        Editor.RemoveAllAlgin();
        tinymce.activeEditor.dom.addClass(tinymce.activeEditor.selection.getNode().parentNode, "align-right-image");
    }
    static AlignCenterImage() {
        Editor.RemoveAllAlgin();
        tinymce.activeEditor.dom.addClass(tinymce.activeEditor.selection.getNode().parentNode, "align-center-image");
    }
    static AlignRight() {
        if (tinymce.activeEditor.selection.getNode().nodeName === "IMG") {
            Editor.RemoveAllAlgin();
            tinymce.activeEditor.dom.addClass(tinymce.activeEditor.selection.getNode().parentNode, "alignright");
        } else {
            tinymce.activeEditor.execCommand("JustifyRight");
            Editor.HideOtherToolbar();
        }
    }
    static AlignCenter() {
        if (tinymce.activeEditor.selection.getNode().nodeName === "IMG") {
            Editor.RemoveAllAlgin();
            tinymce.activeEditor.dom.addClass(tinymce.activeEditor.selection.getNode().parentNode.parentNode, "aligncenter");
        } else {
            tinymce.activeEditor.execCommand("JustifyCenter");
            Editor.HideOtherToolbar();
        }
    }
    static AlignJustify() {
        var nodeName = tinymce.activeEditor.selection.getNode().nodeName;
        if (nodeName !== "IMG") {
            tinymce.activeEditor.execCommand("JustifyFull");
            Editor.HideOtherToolbar();
        }
    }
    static Outdent() {
        var nodeName = tinymce.activeEditor.selection.getNode().nodeName;
        if (nodeName !== "IMG") {
            tinymce.activeEditor.execCommand("Outdent");
            Editor.HideOtherToolbar();
        }
    }
    static Indent() {
        var nodeName = tinymce.activeEditor.selection.getNode().nodeName;
        if (nodeName !== "IMG") {
            tinymce.activeEditor.execCommand("Indent");
            Editor.HideOtherToolbar();
        }
    }
    static RemoveAllAlgin() {
        tinymce.activeEditor.dom.removeClass(tinymce.activeEditor.selection.getNode().parentNode, "align-left-image");
        tinymce.activeEditor.dom.removeClass(tinymce.activeEditor.selection.getNode().parentNode, "align-center-image");
        tinymce.activeEditor.dom.removeClass(tinymce.activeEditor.selection.getNode().parentNode, "align-full-image");
        tinymce.activeEditor.dom.removeClass(tinymce.activeEditor.selection.getNode().parentNode, "align-right-image");
        tinymce.activeEditor.dom.removeClass(tinymce.activeEditor.selection.getNode().parentNode, "double-left-image");
        tinymce.activeEditor.dom.removeClass(tinymce.activeEditor.selection.getNode().parentNode, "double-right-image");
        tinymce.activeEditor.dom.removeClass(tinymce.activeEditor.selection.getNode().parentNode, "full-image");
        $("#imageToolbar").addClass('hidden');
    }
    static DeleteQuote() {
        var selectedNode = tinymce.activeEditor.selection.getNode();
        if (tinymce.activeEditor.selection.getNode().nodeName === "LABEL" && tinymce.activeEditor.selection.getNode().className === "settings") {
            selectedNode.parentNode.remove();
            $("#quoteToolbar").addClass('hidden');
        }
    }
    static AlignCenterQuote() {
        var selectedNode = tinymce.activeEditor.selection.getNode();
        if (!tinymce.activeEditor.selection.getNode().nodeName === "LABEL" && !tinymce.activeEditor.selection.getNode().className === "settings") return;
        tinymce.activeEditor.dom.addClass(tinymce.activeEditor.selection.getNode().parentNode, "w100percent");
        tinymce.activeEditor.dom.removeClass(tinymce.activeEditor.selection.getNode().parentNode, "quotes-right");
        $("#quoteToolbar").addClass('hidden');
    }

    static AlignLeftQuote() {
        var selectedNode = tinymce.activeEditor.selection.getNode();
        if (!tinymce.activeEditor.selection.getNode().nodeName === "LABEL" && !tinymce.activeEditor.selection.getNode().className === "settings") return;
        tinymce.activeEditor.dom.removeClass(tinymce.activeEditor.selection.getNode().parentNode, "w100percent");
        tinymce.activeEditor.dom.removeClass(tinymce.activeEditor.selection.getNode().parentNode, "quotes-right");
        $("#quoteToolbar").addClass('hidden');
    }

    static AlignRightQuote() {
        var selectedNode = tinymce.activeEditor.selection.getNode();
        if (!tinymce.activeEditor.selection.getNode().nodeName === "LABEL" && !tinymce.activeEditor.selection.getNode().className === "settings") return;
        tinymce.activeEditor.dom.addClass(tinymce.activeEditor.selection.getNode().parentNode, "quotes-right");
        tinymce.activeEditor.dom.removeClass(tinymce.activeEditor.selection.getNode().parentNode, "w100percent");
        $("#quoteToolbar").addClass('hidden');
    }

    static UpperCase() {
        tinymce.activeEditor.selection.setContent(htmlDecode(tinymce.activeEditor.selection.getContent()).toUpperCase());
        Editor.HideOtherToolbar();
    }
    static LowerCase() {
        tinymce.activeEditor.selection.setContent(htmlDecode(tinymce.activeEditor.selection.getContent()).toLowerCase());
        Editor.HideOtherToolbar();
    }

    static AddIconQuote() {
        var selectedNode = tinymce.activeEditor.selection.getNode();
        if (!tinymce.activeEditor.selection.getNode().nodeName === "LABEL" && !tinymce.activeEditor.selection.getNode().className === "settings") return;
        tinymce.activeEditor.dom.addClass(tinymce.activeEditor.selection.getNode().parentNode, "icon-quote");
        $("#quoteToolbar").addClass('hidden');
    }
    static RemoveIconQuote() {
        var selectedNode = tinymce.activeEditor.selection.getNode();
        if (!tinymce.activeEditor.selection.getNode().nodeName === "LABEL" && !tinymce.activeEditor.selection.getNode().className === "settings") return;
        tinymce.activeEditor.dom.removeClass(tinymce.activeEditor.selection.getNode().parentNode, "icon-quote");
        $("#quoteToolbar").addClass('hidden');
    }

    static HideImageToolbar() {
        var selectedNode = tinymce.activeEditor.selection.getNode(); // get the selected node (element) in the editor               
        if (selectedNode && selectedNode.nodeName == 'IMG') {
            selectedNode.parentNode.remove();
        }
        $("#imageToolbar").addClass('hidden');
    }

    static HideImageTolbar() {
        $("#imageToolbar").addClass('hidden');
    }
    static HideOtherToolbar() {
        $("#OtherToolbar").addClass('hidden');
    }

    static Bold() {
        var nodeName = tinymce.activeEditor.selection.getNode().nodeName;
        if (nodeName != "IMG") {
            tinymce.activeEditor.execCommand("Bold");
            Editor.HideOtherToolbar();
        }
    }
    static Italic() {
        var nodeName = tinymce.activeEditor.selection.getNode().nodeName;
        if (nodeName != "IMG") {
            tinymce.activeEditor.execCommand("Italic"); Editor.HideOtherToolbar();
        }
    }
    static Underline() {
        var nodeName = tinymce.activeEditor.selection.getNode().nodeName;
        if (nodeName != "IMG") {
            tinymce.activeEditor.execCommand("Underline"); Editor.HideOtherToolbar();
        }
    }

    static Hyperlink() {
        $("#txtTitle").val(htmlDecode(tinymce.activeEditor.selection.getContent()));
        if (tinymce.activeEditor.selection.getNode().nodeName === "A") {
            $("#txtLink").val(tinymce.activeEditor.selection.getNode().href.replace(Client.UrlSite, ''));
        } else {
            $("#txtLink").val("");
        }
        Editor.HideOtherToolbar();
        dialogLink.Show();
        $("#txtLink").focus();
    }
    static ListNumber() {
        tinymce.activeEditor.execCommand("InsertOrderedList");
        Editor.HideOtherToolbar();
    }
    static ListBullet() {
        tinymce.activeEditor.execCommand("InsertUnorderedList");
        Editor.HideOtherToolbar();
    }

}