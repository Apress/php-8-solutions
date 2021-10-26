const cbox = document.getElementById('allowUpload');
cbox.style.display = 'block';
var uploadImage = document.getElementById('upload_new');
uploadImage.onclick = function () {
    const image_id = document.getElementById('image_id');
    const image = document.getElementById('image');
    const caption = document.getElementById('caption');
    const sel = uploadImage.checked;
    image_id.disabled = sel;
    image.parentNode.style.display = sel ? 'block' : 'none';
    caption.parentNode.style.display = sel ? 'block' : 'none';
    image.disabled = !sel;
    caption.disabled = !sel;
}
