function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#avatar_preview').show();
            $('#avatar_preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
$("#avatar_url").on("change", function() {
   readURL(this);
});