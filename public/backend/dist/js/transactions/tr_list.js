// $(window).scroll(function() {
//     if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
//         @this.inceaseTakeAmount();
//     }
// });

// call by all close Edit-form x button to close edit form sub component
// Cancel button click



function hideEditPaymentForm() {
  $('.tr-edit-payment-form-controller').css({ "height": $('.inline-form').height() + 'px', "overflow": "hidden" });
  $('.tr-edit-payment-form-controller').css({ "height": 0 });
  $('.tr-edit-payment-form-controller').on('transitionend webkitTransitionEnd oTransitionEnd', function () {
    $('.tr-edit-payment-form').css("display", "none");
  });
  // $('.tr-edit-payment-form-controller').css({"height":0});
  Livewire.emit('clearEditTransactionCashList');
};

// call by Edit and view button click to close all edit form befor open other edit form
function clearEditPaymentForm() {
  $('.tr-edit-payment-form-controller').css({ "overflow": "hidden" });
  $('.tr-edit-payment-form-controller').on('transitionend webkitTransitionEnd oTransitionEnd', function () {
    $('.tr-edit-payment-form').css("display", "none");
  });
  $('.tr-edit-payment-form-controller').css({ "height": 0 });
};

window.addEventListener('update-payment-alert-success', e => {
  Swal.fire({
    title: 'Success!',
    text: 'Payment update successfully.',
    icon: 'success',
    confirmButtonText: 'OK',

  }).then((e) => {
    // Hide from
    // Clear emit transaction
    // Livewire.emit('refreshCashList');
    Livewire.emit('clearEditTransactionCashList');
  });
});

window.addEventListener('update-add-cash-alert-success', e => {
  Swal.fire({
    title: 'Success!',
    text: 'Cash update successfully.',
    icon: 'success',
    confirmButtonText: 'OK',

  }).then((e) => {
    // Hide from
    // Clear emit transaction
    // Livewire.emit('refreshCashList');
    Livewire.emit('clearEditTransactionCashList');
  });
});

window.addEventListener('update-exchange-alert-success', e => {
  Swal.fire({
    title: 'Success!',
    text: 'Exchange update successfully.',
    icon: 'success',
    confirmButtonText: 'OK',

  }).then((e) => {
    // Hide from
    // Clear emit transaction
    // Livewire.emit('refreshCashList');
    Livewire.emit('clearEditTransactionCashList');
  });
});

function showConfirmDelete(eventName) {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      // @this.deletePaymenet();
      // Livewire.emit('trEditPaymentFormDelete');
      Livewire.emit(eventName);

    }
  });
}

function clearSearchDate(){
  $('#tr_from_date').datetimepicker('clear');
  $('#tr_to_date').datetimepicker('clear');
}

window.addEventListener('trResetRankDateTimePicker', e => {
  $('#tr_from_date').datetimepicker('maxDate', false);
  $('#tr_to_date').datetimepicker('minDate', false);
});


// javascript event hooks
document.addEventListener("DOMContentLoaded", () => {

  // Livewire.hook('component.initialized', (component) => {
  //     console.log('component.name');
  // })

  // Livewire.hook('element.initialized', (el, component) => {
  //     console.log('element.initialized');
  // })

  // Livewire.hook('element.updating', (fromEl, toEl, component) => {
  //     // console.log('element.updating')
  // })

  Livewire.hook('element.updated', (el, component) => {
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();
    // console.log(component.name);

  })

  // Livewire.hook('element.removed', (el, component) => {
  //     console.log('element.removed');
  // })

  // Livewire.hook('message.sent', (message, component) => {
  //     console.log('message.sent');
  // })

  // Livewire.hook('message.failed', (message, component) => {
  //     console.log('message.failed');
  // })

  // Livewire.hook('message.received', (message, component) => {
  //     console.log('message.received');
  // })

  // Livewire.hook('message.processed', (message, component) => {
  //     console.log('message.processed');
  // })

});
