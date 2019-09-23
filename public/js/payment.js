(function() {
console.log('ok')
document.querySelectorAll('[payment-select-method]').forEach(function(actionEl) {
    actionEl.addEventListener('change', function() {
        document.querySelectorAll('[payment-show-method]').forEach(function(hiddenEl) {
            hiddenEl.classList.add('hidden')
        })
        document.querySelectorAll('[payment-show-method='+this.value+']').forEach(function(showEl) {
            showEl.classList.remove('hidden')
        })
    })
})

})()