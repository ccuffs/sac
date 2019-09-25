(function() {
    document.querySelectorAll('[payment-select-method]').forEach(function(actionEl) {
        actionEl.addEventListener('change', function() {
            document.querySelectorAll('[payment-show-method]').forEach(function(hiddenEl) {
                hiddenEl.classList.add('hidden')
            })
            document.querySelectorAll('[payment-show-input]').forEach(function(inputEl) {
                inputEl.removeAttribute('name');
            })
            document.querySelectorAll('[payment-show-method='+actionEl.value+']').forEach(function(showEl) {
                showEl.classList.remove('hidden')
            })
            document.querySelectorAll('[payment-input-type='+actionEl.value+']').forEach(function (inputEl) {
                inputEl.getAttribute('');
            })
            document.querySelectorAll('[payment-show-input='+actionEl.value+']').forEach(function(inputEl) {
                inputEl.setAttribute('name', actionEl.value);
            })
        })
    })
})()