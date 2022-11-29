function debouncer(fn, delay){
    let timeoutId = null;
    return function() {
        clearTimeout(timeoutId)
        const args = arguments
        const that = this
        timeoutId = setTimeout(
            function() {
                fn.apply(that, args)
            },
            delay );
    }
}

module.exports = function debounce(el, binding) {
    if (binding.value !== binding.oldValue) {
        el.oninput = debouncer(function() {
            el.dispatchEvent(new Event('change'))
        }, parseInt(binding.value) || 500)
    }
}