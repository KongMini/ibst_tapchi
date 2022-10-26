var imageDialog = new HDialog("uploadImageWrap", "Quản lý ảnh", ".close-dialog");
let ReturnObject = "";
let ReturnInput = "";
let UpdateImageInfo = false;
let parameterResize = "/w640";
let IsAlbum = false;
var before;
var allowLoadScroll = true;
function validURL(str) {
    var pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
        '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
        '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
        '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
        '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
        '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator
    return !!pattern.test(str);
}
function dragstart_handler(ev, id) {
    before = id;
    ev.dataTransfer.setData("text/html", $(id).html());
}

function dragover_handler(ev, id) {
    ev.preventDefault();
    ev.dataTransfer.dropEffect = "copy";
}

function drop_handler(ev, id) {
    var oldHtml = $(id).html();
    var data = ev.dataTransfer.getData("text/html");
    $(id).html(data);
    if ($(before).hasClass('drop-item') && $(before).html() !== "") {
        $(before).html(oldHtml);
    }
    before = "";
    SortList(id);
}
function SortList(element) {
    var newList = "";
    $(element).parent().find("img").each(function (index) {
        newList += ";" + $(this).attr("src").replace(Client.UrlStatic + "images/upload/", "");
    });
    var nextObject = $(element).parent().next()[0];
    if (nextObject.nodeName === "INPUT" && nextObject.type.toString() === "hidden") $(nextObject).val(newList);
}
$(function () {
    var currentPage = 1;
    $("#uploadImageWrap .tab-content .inside-content").height(heightWindows / 2 - 50);
    $("#aTabImage").click(function () {
        allowLoadScroll = true;
        $("#album-desc").addClass('d-none');
        Images.SelectPaging("", "", "", "", Client.UserID, 1, "#imagesContainer",true);

    });

    $("#btnSearchImage").click(function () {
        currentPage = 1;
        allowLoadScroll = true;
        $("#imagesContainer").html("");
        Images.SelectPaging($("#txtImageKeyword").val(), "", $("#txtImageFromDate").val(), $("#txtImageToDate").val(), $("#" + ddlUserID).val(), 1, "#imagesContainer");
        $('.upload-content .tab-content').removeClass('is-active');
        showTab('tabImage');
        $(".upload-nav .nav-item").removeClass("is-active");
        $(".upload-nav .nav-item[data-target='tabImage']").addClass("is-active");
    });
    function FindImage(page) {
        if (page === undefined) page = 1;
        Images.SelectPaging($("#txtImageKeyword").val(), 0, $("#txtImageFromDate").val(), $("#txtImageToDate").val(), $("#" + ddlUserID).val(), page, "#imagesContainer");
    }

    //sự kiện khi scroll cuối div imagesContainer
    $("#image-list").scroll(function (e) {
        if (allowLoadScroll === false) return false;
        if ($(this).scrollTop() + $(this).innerHeight() + 100 >= $(this)[0].scrollHeight) {
            currentPage = currentPage + 1;
            FindImage(currentPage);
        }
    });

    //sự kiện click vào button chèn ảnh
    $("#btnInsertImage").click(function () {
        Images.InsertImage();
    });

    //sự kiện khi xóa ảnh đã chọn
    $(document).on('click', '.images-chosen .item .remove', function () {
        var data = $(this).next().attr('src').replace(Client.UrlStatic + "images/upload/", ";");
        var inputHandle = $(this).parent().parent().next()[0];
        if (inputHandle.nodeName.toUpperCase() === "INPUT" && inputHandle.type.toString() === "hidden") {
            $(inputHandle).val($(inputHandle).val().replace(data, ""));
        }
        $(this).parent().remove();
    });


    $("#txtCrawlImageFromWeb").bind("paste", function (e) {
        var url = e.originalEvent.clipboardData.getData('text');
        if (validURL(url)) {
            $("#previewImage").html("<img src='" + url + "' style='max-width:75%;max-height:500px'' />");
        }
    });

    $("#txtCrawlImageFromWeb").bind("keydown", function (e) {
        var url = $(this).val();
        if (validURL(url)) $("#previewImage").html("<img src='" + url + "' style='max-width:75%;max-height:500px'' />");
    });

    $("#btnDownloadImageFromWeb").click(function () {
        var url = $("#txtCrawlImageFromWeb").val();
        if (validURL(url)) {
            $.ajax({
                type: "POST",
                url: Client.UrlStatic + "/uploadimage.ashx",
                dataType: "json",
                data: {
                    uploadtype: "url",
                    userName: Client.UserName,
                    userID: Client.UserID,
                    urlimage: url
                }
            }).done(function (image) {
                HAlert("Tải ảnh thành công");
                //Khi upload ảnh xong thì hiển thị dữ liệu mới nhất
                Images.SelectPaging("", "", "", "", Client.UserID, 1, "#imagesContainer", true);
                $("#progress-upload-image").addClass('hidden');
                $('.upload-content .tab-content').removeClass('is-active');
                showTab('tabImage');
                $(".upload-nav .nav-item").removeClass("is-active");
                $(".upload-nav .nav-item[data-target='tabImage']").addClass("is-active");
            }).fail(function () {
                HAlert("Tải ảnh không thành công");
            });
        }
    });


});
class Images {
    static get urlStatic() {
        return Client.UrlStatic;
    }

    static get itemFormat() {
        var formatString = '<div class="col-6 col-md-2 image-item" ondblclick="Images.InsertImage(this);" onclick="Images.ShowInfo(this,event)" data-url="{1}" data-id="{6}" data-cat="{7}" data-keyword="{8}"><img class="img" src="{9}" alt="{0}" />';
        formatString += '<div class="other-info hidden"><p class="text-muted mb-1"><b>{0}</b></p><div><span class="mr-2 bg-light p-1 width-height"><i class="fal fa-window-restore mr-1"></i>{2}</span><span class="mr-2 bg-light p-1"><i class="fal fa-info mr-1"></i>{3} Kb</span><span class="mr-2 bg-light p-1"><i class="fal fa-history mr-1"></i>{4}</span><span class="mr-2 bg-light p-1"><i class="fal fa-user mr-1"></i>{5}</span></div></div></div>';
        return formatString;
    }
    static Upload(input) {

        var files = input.files;
        var count = files.length;
        var form_data = new FormData();

        for (var i = 0; i < count; i++) {

            var reader = new FileReader();
            var fileType = files[i].type;

            //check file upload là dạng ảnh
            if (fileType !== 'image/png' && fileType !== 'image/gif' && fileType !== 'image/jpeg') {
                HAlert('Không hỗ trợ upload file ' + files[i].name + ". Chọn lại ảnh để tiếp tục!");
                $(input).val(""); return false;
            }

            if (files[i].size / (1024 * 1024) > 30) {
                HAlert(files[i].name + ': > 30MB. Chọn lại ảnh để tiếp tục!');
                $(input).val(""); return false;
            }
            var imageName = files[i].name;
            form_data.append('file', files[i]);
            if (i === 0) {
                form_data.append('userID', Client.UserID);
                form_data.append('userName', Client.UserName);
            }
            reader.readAsDataURL(files[i]);
        }

        var xhr = new XMLHttpRequest();
        xhr.upload.addEventListener('progress', Images.updateProgress, false);
        xhr.open('POST', Images.urlStatic + '/uploadImage.ashx', true);
        xhr.onreadystatechange = function (e) {
            if (this.readyState === 4 && this.status === 200) {
                //Khi upload ảnh xong thì hiển thị dữ liệu mới nhất
                Images.SelectPaging("", "", "", "", Client.UserID, 1, "#imagesContainer", true);
                $("#progress-upload-image").addClass('hidden');
                $('.upload-content .tab-content').removeClass('is-active');
                showTab('tabImage');
                $(".upload-nav .nav-item").removeClass("is-active");
                $(".upload-nav .nav-item[data-target='tabImage']").addClass("is-active");
            }
        };
        xhr.send(form_data);
    }
    static updateProgress(oEvent) {
        $("#progress-upload-image").removeClass('hidden');
        if (oEvent.lengthComputable) {
            var percentComplete = oEvent.loaded / oEvent.total;
            if (percentComplete === 1) {
                $("#progress-upload-image .progress-bar").html("Hoàn thành tải ảnh");
                $("#progress-upload-image .progress-bar").width("100%");
            } else {
                $("#progress-upload-image .progress-bar").html((percentComplete * 100).toFixed(0) + "%").width((percentComplete * 100).toFixed(0) + "%").attr('aria-valuenow', (percentComplete * 100).toFixed(0));
            }
        } else {
            HAlert('Total size is unknown');
        }
    }

    static SelectPaging(keyword, catList, startDate, endDate, userId, pageIndex, container, refresh) {
        var url = "action/images.ashx?keyword=" + keyword + "&catlist=0" + "&startDate=" + startDate + "&endDate=" + endDate + "&userID=" + userId + "&page=" + pageIndex;
        var returnValue = "";
        $.getJSON(url, function (data) {
            for (var i = 0; i < data.length; i++) {
                var item = data[i];
                returnValue += Images.itemFormat.format(item.Name, Images.urlStatic + "images/upload/" + item.FilePath, item.Width + "x" + item.Height, (item.Size / 1024).toFixed(1),
                    Utils.ConvertDateJsonToDateVN(item.CreatedDate), item.UserName, item.ID, item.CatList, item.Keyword,
                    Images.urlStatic + "w100/images/upload/" + item.FilePath);
            }
            if (container !== undefined && container !== "") {
                if (refresh === true) {
                    $(container).html(returnValue);
                } else {
                    $(container).html($(container).html() + returnValue);
                }
            } else {
                return returnValue;
            }
        });
    }

    static ShowInfo(element, e) {
        $("#other-info").html($(element).find('.other-info').html());
        console.dir($("#chkMultiChoiceImages").is(":checked"));
        if ($("#chkMultiChoiceImages").is(":checked") === false) {
            $("#imagesContainer .image-item").removeClass('is-selected');
            $(element).addClass('is-selected');
        } else {
            if ($(element).hasClass('is-selected')) {
                $(element).removeClass('is-selected');
            } else {
                $(element).addClass('is-selected');
            }
            return;
        }
    }

    static InsertImage(element) {
        //nếu không có đối tượng hứng sự kiện insert image thì mặc định insert vào Editor
        if (Images.ReturnObject !== undefined || Images.ReturnInput !== undefined) {
            /*nếu người dùng ko sử dụng sự kiện double click vào ảnh để chọn thay vào đó click vào nút chèn ảnh thì kiểm tra có ảnh nào được chọn hay chưa*/
            if (element === undefined) {
                if ($("#imagesContainer div.image-item.is-selected").length === 0) {/*nếu chưa chọn ảnh nào thì thông báo và return*/
                    HAlert('Chọn ít nhất 1 ảnh', true);
                    return false;
                }
            }

            var _returnObject = document.getElementById(Images.ReturnObject);
            var _returnInput = document.getElementById(Images.ReturnInput);
            if (Images.IsAlbum) {
                $("#imagesContainer div.image-item.is-selected").each(function () {
                    element = this;
                    $(_returnObject).append('<div class="item"><img src="' + $(element).attr('data-url').replace("/images/upload/", "/w300/images/upload/") + '" /><span class="delete"></span></div>');
                    $(_returnInput).val($(_returnInput).val() + "," + $(element).attr('data-url').replace(Client.UrlStatic + "images/upload/", ""));
                });
            } else {
                $("#imagesContainer div.image-item.is-selected").each(function () {
                    element = this;
                    $(_returnObject).html($(_returnObject).html() + '<div class="item drop-item" ondragstart="dragstart_handler(event,this);" ondrop="drop_handler(event,this);" ondragover="dragover_handler(event,this);" draggable="true" ><span class="remove"></span><img src="' + $(element).attr('data-url') + '" /></div>');
                    $(_returnInput).val($(_returnInput).val() + ";" + $(element).attr('data-url').replace(Client.UrlStatic + "images/upload/", ""));
                });
            }
            Images.ReturnObject = undefined;
            Images.ReturnInput = undefined;
        } else {
            if (element === undefined && $("#imagesContainer div.image-item.is-selected").length === 0 && Images.UpdateImageInfo === false) {
                HAlert('Chọn ít nhất 1 ảnh', true);
                return;
            }

            var imageFormat = '<figure class="image-wrap align-center-image"><img src="{0}" alt="{3}" data-original="{2}" /><figcaption class="image-caption">{1}</figcaption></figure>';
            var selection = tinymce.activeEditor.selection;

            if ($("#imagesContainer div.image-item.is-selected").length > 1) {
                var allImages = "";
                $("#imagesContainer div.image-item.is-selected").each(function () {
                    element = this;
                    allImages += imageFormat.format($(element).attr('data-url').replace("/images/upload/", parameterResize + "/images/upload/"), "", $(element).attr('data-url'), "");
                });
                if (selection.getContent() === "" && selection.getNode().outerHTML === '') { //trường hợp trong editor chưa có nội dung
                    selection.setContent(allImages, { format: 'raw' });
                } else {
                    if (selection.getNode().innerText.replace(/\s/g, '') === "" && selection.getNode().nodeName !== "BODY") {
                        selection.getNode().remove();
                        selection.setContent(allImages, { format: 'raw' });
                    } else {
                        tinymce.activeEditor.insertContent(allImages);
                    }
                }
                Images.ResetValues();
                return false;
            }

            var dimension;
            if (element === undefined && $("#imagesContainer div.image-item.is-selected").length > 0) element = $("#imagesContainer div.image-item.is-selected");
            if (element !== undefined) dimension = $(element).find("span.width-height").html().split('x');
            if ($("#imagesContainer div.image-item.is-selected").length > 0) {
                //insert new image to editor
                element = $("#imagesContainer div.image-item.is-selected");
                if (parseInt(dimension[0]) >= 9000 || parseInt(dimension[1]) >= 3000) {
                    imageFormat = imageFormat.format($(element).attr('data-url'), $("#txtImageCaption").val(), $(element).attr('data-url'),
                        isBlank($("#txtImageAlt").val()) ? $("#txtImageCaption").val() : $("#txtImageAlt").val());
                } else {
                    imageFormat = imageFormat.format($(element).attr('data-url').replace("/images/upload/", parameterResize + "/images/upload/"), $("#txtImageCaption").val(),
                        $(element).attr('data-url'), isBlank($("#txtImageAlt").val()) ? $("#txtImageCaption").val() : $("#txtImageAlt").val());
                }

                if (selection.getContent() === "" && selection.getNode().outerHTML === '') { //trường hợp trong editor chưa có nội dung
                    selection.setContent(imageFormat, { format: 'raw' });
                } else {
                    if (selection.getNode().innerText.replace(/\s/g, '') === "" && selection.getNode().nodeName !== "BODY") {
                        if (selection.getNode().parentNode !== null && selection.getNode().parentNode.className.indexOf("box-image") < 0) {
                            selection.getNode().remove();
                        }
                        selection.setContent(imageFormat, { format: 'raw' });
                    } else {
                        tinymce.activeEditor.insertContent(imageFormat);
                    }
                }
            } else {
                HAlert("Chọn ảnh để chèn");
                return false;
                //selection.getNode().parentNode.remove();
                //Images.UpdateImageInfo = false;
                //tinymce.activeEditor.selection.setContent(imageFormat, { format: 'raw' });
                //Images.ResetValues();
                //return false;
            }
        }
        Images.ResetValues();
    }
    static ResetValues() {
        $("#txtImageAlt").val('');
        $("#txtImageCaption").val('');
        $("#imagesContainer .image-item").removeClass("is-selected");
        imageDialog.Close();
    }
    static BrowseImages(ReturnObject, ReturnInput, IsAlbum) {
        Images.ReturnObject = ReturnObject;
        Images.ReturnInput = ReturnInput;
        if (IsAlbum !== undefined) Images.IsAlbum = IsAlbum;
        Images.SelectPaging("", "", "", "", Client.UserID, 1, "#imagesContainer");
        imageDialog.Show();
    }

    static ShowCrop() {
        if ($("#imagesContainer .image-item.is-selected").length === 0) {
            HAlert('Chọn ảnh để crop');
            return;
        }
        $("#iframeCrop").attr('height', $("#tabImage").height()).attr('width', $("#tabImage").width());
        var imageSelected = $("#imagesContainer .image-item.is-selected")[0];
        $("#iframeCrop").attr('src', '/other.aspx?cat=crop&img=' + decodeURI($(imageSelected).attr("data-url")));
    }
    static ShowWaterMark() {
        if ($("#imagesContainer .image-item.is-selected").length === 0) {
            HAlert('Chọn ảnh để gắn watermark');
            return;
        }
        $("#iframeWater").attr('height', $("#tabImage").height()).attr('width', $("#tabImage").width());
        var imageSelected = $("#imagesContainer .image-item.is-selected")[0];
        $("#iframeWater").attr('src', '/other.aspx?cat=water&img=' + decodeURI($(imageSelected).attr("data-url")));
    }
}