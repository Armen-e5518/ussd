$(document).on('change', '#user-pass', function () {
    if ($(this).is(':checked')) {
        $('#user-password_hash_update').prop('disabled', false)
    } else {
        $('#user-password_hash_update').prop('disabled', true)
    }

    // $('#edit-field-category-id-target-id').change(function () {
    //     $('#views-exposed-form-members-block-1').submit()
    // })
})


// https://app.operio.immo/api/v1/users/login