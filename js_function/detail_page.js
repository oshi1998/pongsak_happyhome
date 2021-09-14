function viewImageMain(file_name){

    let img = `<img class="img-fluid" src="assets/img/roomtypes/${file_name}">`;

    $('#showFullImage').html(img);
    $('#zoomImageModal').modal('show');
}

function viewImageOther(file_name){

    let img = `<img class="img-fluid" src="assets/img/roomtypes/other/${file_name}">`;

    $('#showFullImage').html(img);
    $('#zoomImageModal').modal('show');
}
