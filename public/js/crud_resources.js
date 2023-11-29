window.addEventListener('new-message', event => {
    console.log(event.detail);
    toastIndex(event.detail[0].message, event.detail[0].status);
});

function toastIndex(message, status) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 2700,
    })

    Toast.fire({

        title: message
    })
}

window.addEventListener('close-modal', (modal) => {
    jQuery.noConflict();
    $('#' + modal.detail).modal('hide');
});