document.addEventListener('variation:selected', (event)  => {
    const variationId = event.detail.variationId

    fetchVariation(variationId)
})

function fetchVariation(variationId) {
    const product = document.querySelector('#product')

    const baseUrl = product.dataset.variationUrl
    const url = baseUrl.replace('__VARIATION__', variationId)

    fetch(url)
        .then(response => response.json())
        .then(data => {
            console.log(data)
        })
}
