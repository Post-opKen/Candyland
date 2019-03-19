/*
* Ean Daus
* 3/18/19
* dynamicInputs.js
* Event handlers for dynamically generating text fields in create.html
*/

$('.multi-field-wrapper').each(function () {
    let wrapper = $('.multi-fields', this);

    //adds a new input
    $(".add-field", $(this)).click(function (e) {
        $('.multi-field:first-child', wrapper).clone(true).appendTo(wrapper).find('input').val('').focus();
    });

    //removes the input
    $('.remove-field', wrapper).click(function () {
        if ($('.multi-field', wrapper).length > 1)
            $(this).parent().parent().parent('.multi-field').remove();
    });
});