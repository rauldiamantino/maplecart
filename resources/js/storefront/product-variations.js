document.addEventListener('DOMContentLoaded', () => {
    const selectedOptions = {}
    const product = document.querySelector('#product')

    if (! product) {
        console.warn('Product element not found')
        return
    }

    const productSchema = JSON.parse(product.dataset.attributes)
    const productVariations = JSON.parse(product.dataset.variations)

    function optionClicked(button) {
        const attribute = button.closest('.attribute-name')
        const currentPosition = Number(attribute.dataset.position)
        const allowedVariations = getVariationsIds(button)

        optionSelected(button, attribute)
        resetNextAttributes(currentPosition)
        showNextAttributes(currentPosition, allowedVariations)
        setFinalVariationId()
    }

    function getVariationsIds(button) {
        return JSON.parse(button.dataset.variations)
    }

    function showNextAttributes(currentPosition, allowedVariations) {
        const attributeNames = document.querySelectorAll('.attribute-name')

        attributeNames.forEach(attribute => {
            const nextPosition = Number(attribute.dataset.position)

            if (nextPosition > currentPosition) {
                attribute.classList.remove('hidden')
                filterOptions(attribute, allowedVariations)
            }
        })
    }

    function optionSelected(button, attribute) {
        const attributeOptions = attribute.querySelectorAll('.attribute-option')
        const dataAttribute = button.dataset.attribute
        const dataValue = button.dataset.value

        attributeOptions.forEach(option => {
            option.classList.remove('selected')
        })

        button.classList.add('selected')

        selectedOptions[dataAttribute] = {
            value: dataValue,
            variations: getVariationsIds(button)
        }
    }

    function setFinalVariationId() {
        const selected = Object.values(selectedOptions)
        product.dataset.variation_id = 0

        if (selected.length !== productSchema.length) {
            return
        }

        let intersection = selected[0].variations

        selected.slice(1).forEach(option => {
            intersection = intersection.filter(id =>
                option.variations.includes(id)
            )
        })

        if (intersection.length === 1) {
            const variationId = intersection[0]

            product.dataset.variation_id = variationId
            console.log('Variation escolhida:', variationId)

            document.dispatchEvent(
                new CustomEvent('variation:selected', {
                    detail: { variationId }
                })
            )
        }
    }

    function resetNextAttributes(currentPosition) {
        const attributeNames = document.querySelectorAll('.attribute-name')

        attributeNames.forEach(attribute => {
            const nextPosition = Number(attribute.dataset.position)

            if (nextPosition > currentPosition) {
                attribute.classList.add('hidden')

                const attributeOptions = attribute.querySelectorAll('.attribute-option')

                attributeOptions.forEach(option => {
                    const dataAttribute = option.dataset.attribute

                    delete selectedOptions[dataAttribute]
                    option.classList.remove('selected')
                    option.hidden = false
                })
            }
        })
    }

    function filterOptions(attribute, allowedVariations) {
        const attributeOptions = attribute.querySelectorAll('.attribute-option')

        attributeOptions.forEach(option => {
            option.hidden = true
        })

        attributeOptions.forEach(option => {
            const optionVariations = getVariationsIds(option)

            const allowed = optionVariations.some(variation =>
                allowedVariations.includes(variation)
            )

            option.hidden = !allowed
        })
    }

    window.optionClicked = optionClicked
})
