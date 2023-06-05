export function debounce(fn, wait = 800) {
    let timer
    return (event) => {
        if (timer) clearTimeout(timer)
        timer = setTimeout(() => {
            if (typeof fn === 'function') {
                fn(event)
            }
        }, wait)
    }
}