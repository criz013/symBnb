$('#add-image').click(function () {

    const index = +$('#widget-counter').val();

    const tpl = $('#annonce_images').data('prototype').replace(/__name__/g, index);
    $('#annonce_images').append(tpl);

    $('#widget-counter').val(index + 1)
    handleDeleteButtons();
})

function handleDeleteButtons() {
    $('button[data-action="delete"]').click(function(){
        const target = this.dataset.target;
        $(target).remove();
    });
}

function updateCounter() {
    const count = +$('#ad_images div.form-group').length;

    $('#widgets-counter').val(count);
}
function updateCounter() {
    const count = +$('#ad_images div.form-group').length;

    $('#widgets-counter').val(count);
}

updateCounter();
handleDeleteButtons();