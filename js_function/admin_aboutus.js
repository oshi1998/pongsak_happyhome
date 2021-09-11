CKEDITOR.replace('editor', {
    extraPlugins: 'filebrowser',
    filebrowserBrowseUrl: 'browseUrl/browse_aboutus.php',
    filebrowserUploadMethod: 'form',
    filebrowserUploadUrl: 'services/uploadImg_aboutus.php',
});

$('#updateAboutUsForm').submit(function (e) {
    e.preventDefault();

    let content = CKEDITOR.instances['editor'].getData();
    let fd = new FormData(this);
    fd.append('content', content);

    $.ajax({
        method: "post",
        url: "services/updateAboutus.php",
        data: fd,
        cache: false,
        contentType: false,
        processData: false
    }).done(function (res) {
        console.log(res);
        swal({
            title: "สำเร็จ!",
            text: res.message,
            icon: "success",
        }).then((action) => {
            window.location.reload();
        });
    }).fail(function (res) {
        console.log(res);
        swal({
            title: "ล้มเหลว!",
            text: res.responseJSON['message'],
            icon: "error",
        });
    });
});